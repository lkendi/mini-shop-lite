<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Forgot Password</h2>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
        Remember your password?
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-400">
            Log in
        </a>
    </p>
</x-guest-layout>
