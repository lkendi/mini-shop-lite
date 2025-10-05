<x-modal name="view-product-modal" :show="$errors->any()" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            View Product Details
        </h2>

        <div class="mt-6 space-y-4 text-gray-900 dark:text-gray-100">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID:</p>
                <p id="view-product-id" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name:</p>
                <p id="view-product-name" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Price:</p>
                <p id="view-product-price" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock:</p>
                <p id="view-product-stock" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Category:</p>
                <p id="view-product-category" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description:</p>
                <p id="view-product-description" class="text-base"></p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Image URL:</p>
                <p id="view-product-image-url" class="text-base break-all"></p>
                <img id="view-product-image" src="" alt="Product Image" class="mt-2 max-w-xs h-auto rounded-lg">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </div>
</x-modal>
