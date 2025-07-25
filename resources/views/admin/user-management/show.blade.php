<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-700">User Detail</h3>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">ID</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Username</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Provider Auth</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ ucfirst($user->provider_auth ?? 'Email') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Premium Expired At</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $user->premium_expired_at ? $user->premium_expired_at->format('d/m/Y') : 'Not Premium' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Roles</p>
                    @foreach ($user->roles as $role)
                        @php
                            $roleName = $role->name;
                            $badgeClass = match ($roleName) {
                                'admin' => 'bg-red-100 text-red-800',
                                'user' => 'bg-blue-100 text-blue-800',
                                'guest' => 'bg-gray-100 text-gray-800',
                                'user_premium', 'premium_user' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                            $displayName = match ($roleName) {
                                'admin' => 'Admin',
                                'user' => 'User',
                                'guest' => 'Guest',
                                'user_premium', 'premium_user' => 'Premium User',
                                default => ucfirst($roleName),
                            };
                        @endphp

                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                            {{ $displayName }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t flex justify-end space-x-3">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Back
                </a>
                <a href="{{ route('users.edit', $user->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Edit User
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
