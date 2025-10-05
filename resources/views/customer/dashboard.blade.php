@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Dashboard</h1>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">Welcome back, {{ Auth::user()->name }}!</p>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Orders</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">View</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">#12345</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Oct 1, 2025</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">$125.50</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Shipped</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="#" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                            </td>
                                        </tr>
                                        <!-- More rows... -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6 text-center">
                                <a href="#" class="text-blue-600 hover:underline dark:text-blue-400">View all orders</a>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Account Details</h3>
                            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Name:</span> {{ Auth::user()->name }}</p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Email:</span> {{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="mt-6 inline-block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700 transition">Edit Profile</a>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('cart') }}" class="text-blue-600 hover:underline dark:text-blue-400">My Cart</a></li>
                                <li><a href="#" class="text-blue-600 hover:underline dark:text-blue-400">Shipping Addresses</a></li>
                                <li><a href="#" class="text-blue-600 hover:underline dark:text-blue-400">Payment Methods</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
