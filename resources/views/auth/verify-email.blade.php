<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Verify Your Email</h2>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-gray-600 dark:text-gray-400 hover:underline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>