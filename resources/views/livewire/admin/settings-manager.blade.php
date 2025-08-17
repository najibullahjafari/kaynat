<div>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Website Settings</h2>
        <x-button.primary wire:click="saveSettings" class="primary-button">
            <i class="fas fa-save mr-2"></i> Save Settings
        </x-button.primary>
    </div>

    <!-- Settings Groups Navigation -->
    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            @foreach($groups as $group)
            @if(isset($availableGroups[$group]))
            <button wire:click="changeGroup('{{ $group }}')" class="secondary-button
                    {{ $activeGroup === $group ? 
                        'bg-primary-500 text-white shadow' : 
                        'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                    }}">
                {{ $availableGroups[$group] }}
            </button>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Settings Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white border-b pb-2">
            {{ $availableGroups[$activeGroup] }} Settings
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($settings as $key => $value)
            @php
            $type = $settingsConfig[$key]['type'] ?? 'text';
            $options = $settingsConfig[$key]['options'] ?? null;
            @endphp

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ ucwords(str_replace('_', ' ', $key)) }}
                </label>

                @if($type === 'textarea')
                <textarea wire:model="settings.{{ $key }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    rows="4"></textarea>

                @elseif($type === 'image')
                <div class="flex items-center space-x-4">
                    @if($value)
                    @if(isset($settings[$key]) && $settings[$key])
                    <img src="{{ isset($tempImages[$key]) && $tempImages[$key] ? $tempImages[$key]->temporaryUrl() : Storage::url($settings[$key]) }}"
                        class="h-16 w-16 object-contain rounded border">
                    @endif
                    @endif
                    <div class="flex-1">
                        <input type="file" wire:model="tempImages.{{ $key }}"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        @if(isset($settings[$key]) && $settings[$key])


                        <button type="button" wire:click="$set('settings.{{ $key }}', '')"
                            class="mt-2 text-sm text-red-600 hover:text-red-800">
                            <i class="fas fa-trash mr-1"></i> Remove Image
                        </button>
                        @endif
                    </div>
                </div>

                @elseif($type === 'boolean')
                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                    <input type="checkbox" wire:model="settings.{{ $key }}" id="toggle_{{ $key }}" class="sr-only" {{
                        $value ? 'checked' : '' }}>
                    <label for="toggle_{{ $key }}" class="block h-6 w-10 cursor-pointer rounded-full bg-gray-300 dark:bg-gray-600 transition-colors duration-200 ease-in-out
                                    {{ $value ? 'bg-primary-500' : '' }}">
                        <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 ease-in-out
                                    {{ $value ? 'transform translate-x-4' : '' }}"></span>
                    </label>
                </div>

                @elseif($type === 'select' && $options)
                <select wire:model="settings.{{ $key }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    @foreach($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                    @endforeach
                </select>

                @elseif($type === 'color')
                <div class="flex items-center space-x-3">
                    <input type="color" wire:model="settings.{{ $key }}"
                        class="w-10 h-10 p-1 border border-gray-300 rounded cursor-pointer">
                    <input type="text" wire:model="settings.{{ $key }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                @else
                <input type="{{ $type }}" wire:model="settings.{{ $key }}" @if($type==='password' )
                    autocomplete="new-password" @endif
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                @endif

                @error('settings.'.$key)
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>
    </div>

    <!-- Preview Section -->
    @if($activeGroup === 'appearance')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white border-b pb-2">
            Theme Preview
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Color Preview -->
            <div>
                <h4 class="font-medium mb-3">Color Palette</h4>
                <div class="flex flex-wrap gap-3">
                    <div class="w-16 h-16 rounded-lg shadow" style="background-color: {{ $settings['primary_color'] }}">
                    </div>
                    <div class="w-16 h-16 rounded-lg shadow"
                        style="background-color: {{ $settings['secondary_color'] }}"></div>
                    <div class="w-16 h-16 rounded-lg shadow" style="background-color: {{ $settings['accent_color'] }}">
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                    <p>Primary: {{ $settings['primary_color'] }}</p>
                    <p>Secondary: {{ $settings['secondary_color'] }}</p>
                    <p>Accent: {{ $settings['accent_color'] }}</p>
                </div>
            </div>

            <!-- Component Preview -->
            <div>
                <h4 class="font-medium mb-3">UI Components</h4>
                <div class="space-y-3">
                    <button class="px-4 py-2 rounded bg-primary-500 text-white font-medium">
                        Primary Button
                    </button>
                    <button class="px-4 py-2 rounded bg-secondary-500 text-white font-medium">
                        Secondary Button
                    </button>
                    <div class="p-4 rounded border border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">Sample card with border</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>