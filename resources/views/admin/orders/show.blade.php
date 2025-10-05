@extends('layouts.app')

@section('title', 'Admin Order #'. $order->id)

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Order Details #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Back to All Orders &rarr;</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Order Information</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Status:</strong> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' : 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>

                    @if ($order->status === 'pending')
                        <form action="{{ route('admin.orders.complete', $order) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <x-heroicon-o-check-circle class="-ml-1 mr-2 h-5 w-5" />
                                Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Customer Information</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Items in this Order</h2>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <li class="flex py-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/64' }}" alt="{{ $item->product->name ?? 'Product Image' }}" class="w-16 h-16 rounded-md object-cover">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col">
                                <div class="flex justify-between">
                                    <p class="text-base font-medium text-gray-900 dark:text-white">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Qty: {{ $item->quantity }} @ ${{ number_format($item->price, 2) }} each</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
