<x-modal name="edit-customer-modal" :show="$errors->any()" focusable>
    <form method="post" action="" class="p-6" id="edit-customer-form">
        @csrf
        @method('patch')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Edit Customer
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Update the customer details below.
        </p>

        <div class="mt-6 space-y-4">
            <div>
                <x-input-label for="edit_customer_name" value="Name" />
                <x-text-input id="edit_customer_name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="edit_customer_email" value="Email" />
                <x-text-input id="edit_customer_email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="edit_customer_role" value="Role" />
                <x-text-input id="edit_customer_role" name="role" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('role')" />
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
