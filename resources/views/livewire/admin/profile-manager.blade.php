<div class=" mx-auto bg-white rounded-lg shadow-sm p-8 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit Profile</h2>

    @if (session()->has('status'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-center">
        {{ session('status') }}
    </div>
    @endif

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="name">Name</label>
            <input wire:model.defer="name" id="name" type="text"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
            <input wire:model.defer="email" id="email" type="email"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="password">New Password</label>
            <input wire:model.defer="password" id="password" type="password"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2" for="password_confirmation">Confirm Password</label>
            <input wire:model.defer="password_confirmation" id="password_confirmation" type="password"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" class="primary-button">Save
            Changes</button>
    </form>
</div>