<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!--  Search + Filter -->
                    <form method="GET" action="{{ route('categories.index') }}" class="flex items-center mb-4 space-x-4">
                        <input type="text" name="search" placeholder="{{ __('Enter category name...') }}"
                            value="{{ request('search') }}" class="border rounded px-3 py-2 text-sm w-1/3" />

                        <select name="type" class="border rounded px-3 py-2 text-sm">
                            <option value="">{{ __('All Category') }}</option>
                            @foreach ($typeConfig as $key => $data)
                                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                    {{ __($data['label']) }}
                                </option>
                            @endforeach
                        </select>

                        <select name="wallet_type" class="border rounded px-3 py-2 text-sm">
                            <option value="">{{ __('All Wallet Types') }}</option>
                            @foreach ($walletConfig as $id => $config)
                                <option value="{{ $id }}"
                                    {{ request('wallet_type') == $id ? 'selected' : '' }}>
                                    {{ __($config['label']) }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                            {{ __('Search') }}
                        </button>
                    </form>

                    <x-flash-message />

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('categories.create') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
                            {{ __('category.add_category') }}
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">{{ __('ID') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">
                                    {{ __('category.category_name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">
                                    {{ __('category.category_type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">
                                    {{ __('category.category_parent') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">
                                    {{ __('Created By') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">
                                    {{ __('category.wallet_apply') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">{{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $category->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 align-middle">
                                        @php
                                            $categoryType = $typeConfig[$category->type] ?? [
                                                'label' => __('Other'),
                                                'class' => 'bg-gray-100 text-gray-800',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $categoryType['class'] }}">
                                            {{ __($categoryType['label']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $category->parent->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $category->creator->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @forelse ($category->wallet_display as $wallet)
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $wallet['class'] }}">
                                                {{ __($wallet['label']) }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400">-</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4 text-sm flex space-x-4">
                                        <a href="{{ route('categories.show', $category->id) }}"
                                            class="text-green-600 hover:text-green-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}\n\n{{ __('All related transactions and wallet type settings will be permanently deleted.') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 italic">
                                        {{ __('No data') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
