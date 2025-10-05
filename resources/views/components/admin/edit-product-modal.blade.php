<x-modal name="edit-product-modal" :show="$errors->any()" focusable>
    <form method="post" action="" class="p-6" id="edit-product-form">
        @csrf
        @method('patch')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Edit Product
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Update the product details below.
        </p>

        <div class="mt-6 space-y-4">
            <div>
                <x-input-label for="edit_name" value="Name" />
                <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required autofocus value="{{ old('name') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="edit_price" value="Price" />
                <x-text-input id="edit_price" name="price" type="number" step="0.01" class="mt-1 block w-full" required value="{{ old('price') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('price')" />
            </div>

            <div>
                <x-input-label for="edit_stock" value="Stock" />
                <x-text-input id="edit_stock" name="stock" type="number" class="mt-1 block w-full" required value="{{ old('stock') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('stock')" />
            </div>

            <div>
                <x-input-label for="edit_category" value="Category" />
                <select id="edit_category" name="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">-- Select category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                    <option value="Other">Other</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category')" />
            </div>

            <div>
                <x-input-label for="edit_description" value="Description" />
                <textarea id="edit_description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="edit_image_url" value="Image URL" />
                <x-text-input id="edit_image_url" name="image_url" type="text" class="mt-1 block w-full" value="{{ old('image_url') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Save Changes') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
