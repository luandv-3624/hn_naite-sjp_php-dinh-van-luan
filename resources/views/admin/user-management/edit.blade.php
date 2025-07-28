<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto" x-data="{
        role: '{{ $user->hasRole('premium_user') ? 'premium_user' : $user->roles->first()->name ?? '' }}',
        permanent: {{ $user->premium_expired_at === null && $user->hasRole('premium_user') ? 'true' : 'false' }}
    }">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('User Information') }}</h3>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">{{ __('Username') }}</label>
                    <input type="text" name="username" value="{{ old('username', $user->name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">{{ __('Role') }}</label>
                    <select name="role" x-model="role"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="user">User</option>
                        <option value="guest">Guest</option>
                        <option value="admin">Admin</option>
                        <option value="premium_user">Premium User</option>
                    </select>

                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Premium Options -->
                <div class="mb-4" x-show="role === 'premium_user'">
                    <label class="block text-gray-700 font-medium">{{ __('Premium Expired At') }}</label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="date" name="premium_expired_at"
                            value="{{ old('premium_expired_at', $user->premium_expired_at ? $user->premium_expired_at->format('Y-m-d') : '') }}"
                            class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            x-bind:disabled="permanent">

                        <label class="inline-flex items-center">
                            <input type="checkbox" name="premium_permanent" x-model="permanent"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700 text-sm">{{ __('Permanent') }}</span>
                        </label>
                    </div>

                    @error('premium_expired_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Submit -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
