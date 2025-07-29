<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('category.add_category') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-medium">{{ __('category.category_name') }}</label>
                    <input type="text" name="name" class="border rounded px-3 py-2 w-full"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium">{{ __('category.category_type') }}</label>
                    <select name="type" class="border rounded px-3 py-2 w-full" required>
                        <option value="">{{ __('category.select_type') }}</option>
                        @foreach ($typeConfig as $key => $data)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                {{ __($data['label']) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium">{{ __('category.category_parent') }}</label>
                    <select name="category_parent_id" class="border rounded px-3 py-2 w-full">
                        <option value="">{{ __('None') }}</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('category_parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_parent_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium"> {{ __('category.wallet_apply') }}</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach ($walletConfig as $id => $wallet)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="wallet_types[]" value="{{ $id }}"
                                    {{ in_array($id, old('wallet_types', [])) ? 'checked' : '' }}>
                                <span class="{{ $wallet['class'] }} text-md font-medium px-2 rounded">
                                    {{ __($wallet['label']) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('wallet_types')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('categories.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
