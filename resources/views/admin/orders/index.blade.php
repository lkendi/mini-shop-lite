@extends('layouts.app')

@section('title', 'Admin Orders')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">All Orders</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            @if($orders->isEmpty())
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-archive-box class="mx-auto h-12 w-12 text-gray-400" />
                    <p class="mt-2">No orders have been placed yet.</p>
                </div>
            @else
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($orders as $order)
                            <li class="p-4 sm:p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Order #{{ $order->id }}</p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">By: {{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? 'N/A' }})</p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</p>
                                        <span class="ml-3 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' : 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">View Details &rarr;</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
