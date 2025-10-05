<x-modal name="create-product-modal" :show="$errors->any()" focusable>
    <form method="post" action="" class="p-6" id="create-product-form">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Create Product
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Add a new product to your store.
        </p>

        <input type="hidden" name="redirect_to" id="create_redirect_to" value="">

        <div class="mt-6 space-y-4">
            <div>
                <x-input-label for="create_name" value="Name" />
                <x-text-input id="create_name" name="name" type="text" class="mt-1 block w-full" required autofocus value="{{ old('name') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="create_price" value="Price" />
                <x-text-input id="create_price" name="price" type="number" step="0.01" class="mt-1 block w-full" required value="{{ old('price') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('price')" />
            </div>

            <div>
                <x-input-label for="create_stock" value="Stock" />
                <x-text-input id="create_stock" name="stock" type="number" class="mt-1 block w-full" required value="{{ old('stock') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('stock')" />
            </div>

            <div>
                <x-input-label for="create_category_select" value="Category" />
                <select id="create_category_select" name="category_select" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">-- Select category --</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat }}" {{ old('category_select') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                    <option value="__other">Other...</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category')" />

                <div id="create_category_other_wrap" class="mt-2 hidden">
                    <x-text-input id="create_category_other" name="category" type="text" class="block w-full" placeholder="Enter custom category" value="{{ old('category') }}" />
                </div>
            </div>

            <div>
                <x-input-label for="create_description" value="Description" />
                <textarea id="create_description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="create_image_url" value="Image URL" />
                <x-text-input id="create_image_url" name="image_url" type="text" class="mt-1 block w-full" value="{{ old('image_url') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Create Product') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
