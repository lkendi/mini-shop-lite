@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div id="cart-error-container" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline ml-2" id="cart-error-message"></span>
        </div>
        
        @if(empty($cart['items']))
            <div class="text-center py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <x-heroicon-o-shopping-cart class="mx-auto h-12 w-12 text-gray-400" />
                <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Your cart is empty</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Looks like you haven't added anything to your cart yet.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-o-arrow-left class="-ml-1 mr-2 h-5 w-5" />
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Shopping Cart</h1>
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Continue Shopping &rarr;</a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart['items'] as $id => $item)
                            <li class="p-4 sm:p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base font-medium text-gray-900 dark:text-white truncate">{{ $item['name'] }}</p>
                                        <div class="flex items-center mt-1">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($item['price'], 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 sm:space-x-4">
                                        <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-md">
                                            <button type="button" onclick="updateQuantity('{{ $id }}', {{ $item['quantity'] - 1 }})" class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 disabled:opacity-50" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                <x-heroicon-m-minus class="h-4 w-4"/>
                                            </button>
                                            <input type="text" value="{{ $item['quantity'] }}" class="w-10 text-center bg-transparent border-0 text-sm font-medium focus:ring-0" readonly>
                                            <button type="button" onclick="updateQuantity('{{ $id }}', {{ $item['quantity'] + 1 }})" class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                <x-heroicon-m-plus class="h-4 w-4"/>
                                            </button>
                                        </div>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-500">
                                                <span class="sr-only">Remove</span>
                                                <x-heroicon-o-trash class="h-5 w-5"/>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-8 sm:mt-12">
                <div class="w-full max-w-sm mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Order summary</h2>
                    <div class="mt-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <dl class="space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($cart['total'], 2) }}</dd>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">$5.00</dd>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 flex items-center justify-between">
                                <dt class="text-base font-medium text-gray-900 dark:text-white">Order total</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">${{ number_format($cart['total'] + 5.00, 2) }}</dd>
                            </div>
                        </dl>
                        <div class="mt-6">
                            <button type="button" class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 dark:focus:ring-offset-gray-800 focus:ring-blue-500">Checkout</button>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-500">Clear Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
