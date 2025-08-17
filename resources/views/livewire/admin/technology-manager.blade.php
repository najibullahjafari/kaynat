{{-- filepath: resources/views/livewire/admin/technology-manager.blade.php --}}
<div>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Technology Management</h2>
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <input type="text" wire:model="search" placeholder="Search technology..."
                class="w-full md:w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" />
            <button type="button" wire:click="create" class="primary-button">
                <i class="fas fa-plus mr-2"></i> Add New
            </button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none"
                        wire:click="sortBy('name')">
                        Name
                        @if($sortField === 'name')
                        <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" class="h-10 w-10 object-cover rounded" />
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                        <button wire:click="edit({{ $item->id }})" class="p-2 rounded hover:bg-gray-100 text-primary"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button wire:click="confirmDelete({{ $item->id }})"
                            class="p-2 rounded hover:bg-gray-100 text-red-600" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No technology items found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

    <!-- Modal & Delete Confirmation -->
    <div x-data="{ show: @entangle('showModal'), confirmDeleteId: @entangle('confirmDeleteId') }" x-init="$watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        })" x-cloak>
        <!-- Technology Modal -->
        <div x-show="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="show = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4" x-transition>
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        {{ $currentItem ? 'Edit Technology' : 'Create New Technology' }}
                    </h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model.defer="form.name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" />
                            @error('form.name')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <input type="text" wire:model.defer="form.type" id="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" />
                            @error('form.type')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model.defer="form.description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"></textarea>
                            @error('form.description')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            @if($tempImage)
                            <div class="mb-2">
                                <img src="{{ $tempImage->temporaryUrl() }}" class="h-24 object-cover rounded">
                            </div>
                            @elseif($form['image'])
                            <div class="mb-2">
                                <img src="{{ Storage::url($form['image']) }}" class="h-24 object-cover rounded">
                            </div>
                            @endif
                            <input type="file" wire:model="tempImage" id="image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark" />
                            @error('tempImage')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="specifications" class="block text-sm font-medium text-gray-700">Specifications
                                (comma separated)</label>
                            <input type="text" wire:model.defer="form.specifications_string" id="specifications"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                                placeholder="e.g. Fast, Lightweight, Durable" />
                            @error('form.specifications')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.defer="form.is_active" id="is_active"
                                class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" />
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-2">
                        <button type="button" @click="show = false"
                            class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="secondary-button">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal (with browser event support) -->
        <div x-data="{ show: false, id: null, message: '' }" x-init="
                window.addEventListener('confirm-delete', e => {
                    show = true;
                    id = e.detail.id;
                    message = e.detail.message || 'Are you sure you want to delete this technology?';
                });
            " x-show="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 p-6 text-center" x-transition>
                <h3 class="text-lg font-semibold mb-4">Delete Technology</h3>
                <p class="mb-6 text-gray-600" x-text="message">Are you sure you want to delete this technology?</p>
                <div class="flex justify-center space-x-4">
                    <button @click="show = false; id = null; message = ''"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                    <button @click="$wire.delete(id); show = false; id = null; message = ''"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>