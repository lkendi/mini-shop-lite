@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">My Dashboard</h1>
            <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500 dark:text-gray-400">Welcome back, {{ Auth::user()->name }}!</p>
            <p class="mt-1 max-w-2xl mx-auto text-md text-gray-500 dark:text-gray-400">From here you can manage your account, view your cart, and browse our products.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center flex flex-col justify-between">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/50">
                        <x-heroicon-o-user class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">My Account</h3>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-6 inline-block w-full bg-white dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Edit Profile</a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center flex flex-col justify-between">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/50">
                        <x-heroicon-o-shopping-cart class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">My Cart</h3>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <p>You have {{ $cart['count'] }} items in your cart.</p>
                    </div>
                </div>
                <a href="{{ route('cart.index') }}" class="mt-6 inline-block w-full bg-green-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-green-700">View Cart</a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center flex flex-col justify-between">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900/50">
                        <x-heroicon-o-shopping-bag class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Go Shopping</h3>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <p>Find your next favorite item in our collection.</p>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="mt-6 inline-block w-full bg-purple-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-purple-700">Browse Products</a>
            </div>
        </div>
    </div>
</div>
@endsection
