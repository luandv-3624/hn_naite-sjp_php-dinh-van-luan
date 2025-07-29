<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('currency.currency_management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('currencies.index') }}" class="mb-4 flex items-center space-x-4">
                        <input type="text" name="search"
                            placeholder="{{ __('currency.search_currency_placeholder') }}"
                            value="{{ request('search') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300">

                        <input type="date" name="date" value="{{ $selectedDate }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300">

                        <button type="submit"
                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">{{ __('Search') }}</button>

                        <a href="{{ route('currencies.index') }}"
                            class="text-sm text-gray-500 ml-2">{{ __('currency.reset') }}</a>
                    </form>

                    <x-flash-message />

                    <!-- Button Cập nhật tỷ giá -->
                    <div class="flex justify-end mb-4">
                        <form action="{{ route('currencies.updateExchangeRates') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">{{ __('currency.update_exchange_rate') }}</button>
                        </form>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('ID') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('currency.currency_name') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('currency.code') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('currency.symbol') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('currency.exchange_rate') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('currency.is_default') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($currencies as $currency)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $currency->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $currency->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $currency->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $currency->symbol }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $rateForDate = $currency->exchangeRates->first();
                                        @endphp
                                        {{ $rateForDate ? $rateForDate->rate : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($currency->is_default)
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ __('Default') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 text-xs">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm flex space-x-4">
                                        <a href="#" class="text-green-600 hover:text-green-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="#" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this currency?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                title="Delete">
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
                        {{ $currencies->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
