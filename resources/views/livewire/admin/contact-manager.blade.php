{{-- filepath: resources/views/livewire/admin/contact-manager.blade.php --}}
<div>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Contact Management</h2>
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <input type="text" wire:model="search" placeholder="Search contacts..."
                class="w-full md:w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" />
            {{-- <button type="button" wire:click="create"
                class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-plus mr-2"></i> Add New
            </button> --}}
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Read</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($items as $item)
                <tr @class(['bg-gray-50'=> !$item->is_read])>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->subject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ Str::limit($item->message, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->is_read)
                        <span
                            class="inline-block px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">Read</span>
                        @else
                        <span
                            class="inline-block px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">Unread</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                        @if(!$item->is_read)
                        <button wire:click="markAsRead({{ $item->id }})"
                            class="p-2 rounded hover:bg-gray-100 text-blue-600" title="Mark as Read">
                            <i class="fas fa-envelope-open"></i>
                        </button>
                        @endif
                        <button wire:click="edit({{ $item->id }})" class="p-2 rounded hover:bg-gray-100 text-primary"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button
                            onclick="if(confirm('Are you sure you want to delete this contact?')) { @this.delete({{ $item->id }}) }"
                            class="p-2 rounded hover:bg-gray-100 text-red-600" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No contacts found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

    <!-- Modal & Delete Confirmation -->
    <div x-data="{ show: @entangle('showModal'), confirmDeleteId: null }" x-init="$watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        })" x-cloak>
        <!-- Contact Modal -->
        <div x-show="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="show = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4" x-transition>
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        {{ $currentItem ? 'Edit Contact' : 'Create New Contact' }}
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
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="form.email" id="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" />
                            @error('form.email')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" wire:model.defer="form.phone" id="phone"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" />
                            @error('form.phone')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" wire:model.defer="form.subject" id="subject"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" />
                            @error('form.subject')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea wire:model.defer="form.message" id="message" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"></textarea>
                            @error('form.message')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.defer="form.is_read" id="is_read"
                                class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" />
                            <label for="is_read" class="ml-2 block text-sm text-gray-700">Read</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-2">
                        <button type="button" @click="show = false"
                            class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-primary text-white hover:bg-primary-dark">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="confirmDeleteId !== null"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 p-6 text-center" x-transition>
                <h3 class="text-lg font-semibold mb-4">Delete Contact</h3>
                <p class="mb-6 text-gray-600">Are you sure you want to delete this contact?</p>
                <div class="flex justify-center space-x-4">
                    <button @click="confirmDeleteId = null"
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
                    <button @click="$wire.delete(confirmDeleteId); confirmDeleteId = null"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>