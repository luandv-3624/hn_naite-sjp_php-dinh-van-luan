<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('category.category_detail') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-700">{{ __('category.category_detail') }}</h3>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">{{ __('ID') }}</p>
                        <p class="text-base font-semibold text-gray-800">{{ $category->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('category.category_name') }}</p>
                        <p class="text-base font-semibold text-gray-800">{{ $category->name }}</p>
                    </div>

                    <div>
                        @php
                            $categoryType = $typeConfig[$category->type] ?? [
                                'label' => __('Other'),
                                'class' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <p class="text-sm text-gray-500">{{ __('category.category_type') }}</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $categoryType['class'] }}">
                            {{ __($categoryType['label']) }}
                            </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('category.category_parent') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $category->parent->name ?? __('None') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Created By') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $category->creator->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ __('Created At') }}</p>
                        <p class="text-base font-semibold text-gray-800">
                            {{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">{{ __('category.wallet_apply') }}</p>
                    @forelse ($category->walletTypes as $wallet)
                        @php
                            $badge = $walletConfig[$wallet->id] ?? [
                                'label' => $wallet->name,
                                'class' => 'text-gray-400',
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $badge['class'] }}">
                            {{ __($badge['label']) }}
                        </span>
                    @empty
                        <span class="text-xs text-gray-400 italic">{{ __('No wallet types assigned') }}</span>
                    @endforelse
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t flex justify-end space-x-3">
                <a href="{{ route('categories.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    {{ __('Back') }}
                </a>
                <a href="{{ route('categories.edit', $category->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    {{ __('Update') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
