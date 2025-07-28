<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-700">{{ __('User Detail') }}</h3>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">{{ __('ID') }}</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Username') }}</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Email') }}</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Provider Auth') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ ucfirst($user->provider_auth ?? 'Email') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Premium Expired At') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $user->premium_expired_at ? $user->premium_expired_at->format('d/m/Y') : __('Not Premium') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Created At') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">{{ __('Roles') }}</p>
                    @forelse ($user->roles as $role)
                        @php
                            $badge = $roleBadges[$role->name] ?? $defaultBadge;
                        @endphp
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    @empty
                        <span class="text-xs text-gray-400 italic">{{ __('No roles assigned') }}</span>
                    @endforelse
                </div>

            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t flex justify-end space-x-3">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    {{ __('Back') }}
                </a>
                <a href="{{ route('users.edit', $user->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    {{ __('Edit User') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
