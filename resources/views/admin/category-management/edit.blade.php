<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('category.category_name') }}</label>

                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('category.category_type') }}</label>
                    <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($typeConfig as $key => $data)
                            <option value="{{ $key }}"
                                {{ old('type', $category->type) == $key ? 'selected' : '' }}>
                                {{ __($data['label']) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('category.category_parent') }}</label>
                    <select name="category_parent_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">{{ __('None') }}</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('category_parent_id', $category->category_parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('category.wallet_apply') }}</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($walletConfig as $id => $item)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="wallet_types[]" value="{{ $id }}"
                                    class="rounded" @if (in_array((string) $id, collect(old('wallet_types', $selectedWalletTypes))->map(fn($v) => (string) $v)->all())) checked @endif>
                                <span
                                    class="{{ $item['class'] }} text-md font-medium px-2 rounded">{{ __($item['label']) }}</span>
                            </label>
                        @endforeach

                    </div>
                    @error('wallet_types')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('categories.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
