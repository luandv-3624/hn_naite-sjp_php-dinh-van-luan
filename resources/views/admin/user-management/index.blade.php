<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="GET" action="{{ route('users.index') }}" class="flex items-center mb-4 space-x-4">
                        <input type="text" name="search" placeholder="Search username or email"
                            value="{{ request('search') }}" class="border rounded px-3 py-2 text-sm w-1/3" />

                        <select name="role" class="border rounded px-3 py-2 text-sm">
                            <option value="">{{ __('All Roles') }}</option>
                            @foreach ($roleBadges as $key => $role)
                                <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>
                                    {{ $role['label'] }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                            {{ __('Search') }}
                        </button>
                    </form>

                    <x-flash-message />

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('ID') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Username') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Email') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Roles') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Premium Expired') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @forelse ($user->roles as $role)
                                            @php
                                                $badge = $roleBadges[$role->name] ?? $defaultBadge;
                                            @endphp
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold rounded-full {{ $badge['class'] }}">
                                                {{ $badge['label'] }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500 italic">{{ __('No roles assigned') }}</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->premium_expired_at ? $user->premium_expired_at->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm flex space-x-4">
                                        <!-- View -->
                                        <a href="{{ route('users.show', $user->id) }}"
                                            class="text-green-600 hover:text-green-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <!-- Delete -->
                                        @if (!$user->hasRole('admin'))
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
