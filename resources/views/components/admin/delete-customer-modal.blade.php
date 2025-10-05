<x-modal name="delete-customer-modal" :show="$errors->any()" focusable>
    <form method="post" action="" class="p-6" id="delete-customer-form">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Are you sure you want to delete this customer?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Once this customer is deleted, all of their data will be permanently deleted. Please
            confirm you would like to permanently delete this customer.
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Customer') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>