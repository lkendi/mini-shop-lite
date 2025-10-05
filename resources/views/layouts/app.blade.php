<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MiniShop Lite - Modern Store')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans min-h-screen flex flex-col">

    <header id="header" class="sticky top-0 z-40 w-full backdrop-blur-sm bg-white/70 dark:bg-gray-900/70 border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <x-heroicon-o-shopping-bag class="h-8 w-8 text-blue-600 dark:text-blue-500" />
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">MiniShop</span>
                    </a>
                </div>

                <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2">
                    <div class="flex items-center space-x-8">
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Dashboard</a>
                                <a href="{{ route('admin.products.index') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Products</a>
                                <a href="{{ route('admin.customers.index') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Customers</a>
                            @else
                                <a href="{{ route('home') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Home</a>
                                <a href="{{ route('products.index') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Products</a>
                            @endif
                        @else
                            <a href="{{ route('home') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Home</a>
                            <a href="{{ route('products.index') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Products</a>
                        @endauth

                        @if (!Auth::check() || Auth::user()->role !== 'admin')
                            <a href="{{ route('cart.index') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Cart</a>
                        @endif
                    </div>
                </div>


                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-transparent hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                    <x-heroicon-o-user-circle class="h-6 w-6 mr-1" />
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Login</a>
                        <a href="{{ route('register') }}" class="font-medium text-white bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700">Register</a>
                    @endguest


                    <button id="theme-toggle" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">
                        <x-heroicon-o-moon id="theme-toggle-dark-icon" class="h-6 w-6 hidden" />
                        <x-heroicon-o-sun id="theme-toggle-light-icon" class="h-6 w-6 hidden" />
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 focus:outline-none">
                        <x-heroicon-o-bars-3 id="hamburger-icon" class="h-6 w-6" />
                        <x-heroicon-o-x-mark id="close-icon" class="h-6 w-6 hidden" />
                    </button>
                </div>
            </div>
        </nav>

        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Products</a>
                        <a href="{{ route('admin.customers.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Customers</a>
                    @else
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Home</a>
                        <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Products</a>
                        <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Cart</a>
                    @endif
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Home</a>
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Products</a>
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Cart</a>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Login</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('hero')
        @yield('content')
    </main>

    <footer class="bg-transparent border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-base text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} MiniShop Lite.</p>
        </div>
    </footer>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('dark-mode', 'false');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('dark-mode', 'true');
                }
            });

            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                hamburgerIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
