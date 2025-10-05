@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Admin Products') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Product List</h3>
                        <button id="open-create-product" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Product
                        </button>
                    </div>

                    <!-- Filters and Search Bar (component) -->
                    <x-filters :action="route('admin.products.index')" :categories="$categories" />

                    <!-- Results Summary -->
                    @if(request()->has('search') || request()->has('category') || request()->has('sort'))
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Showing {{ $products->count() }} of {{ $products->total() }} products
                            @if(request('search')) matching "{{ request('search') }}"@endif
                            @if(request('category') && request('category') !== 'all') in {{ request('category') }}@endif
                        </p>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($products as $product)
                                    <tr class="even:bg-gray-50 dark:even:bg-gray-700 odd:bg-white dark:odd:bg-gray-800">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${{ number_format($product->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $product->stock }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $product->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3 view-product" data-id="{{ $product->id }}">View</button>
                                            <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3 edit-product" data-id="{{ $product->id }}">Edit</button>
                                            <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 delete-product" data-id="{{ $product->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.view-product-modal />
    <x-admin.edit-product-modal :categories="$categories" />
    <x-admin.delete-product-modal />
    <x-admin.create-product-modal :categories="$categories" />


    @push('scripts')
        <script src="{{ asset('js/admin-products.js') }}"></script>
        <script>
            // Set create form action to admin product store route
            document.addEventListener('DOMContentLoaded', function () {
                const openBtn = document.getElementById('open-create-product');
                const createForm = document.getElementById('create-product-form');
                const redirectInput = document.getElementById('create_redirect_to');
                if (createForm) {
                    createForm.action = "{{ route('admin.products.store') }}";
                    // store current URL so after submit the controller can redirect back to same page
                    if (redirectInput) redirectInput.value = window.location.pathname + window.location.search;
                }

                if (openBtn) {
                    openBtn.addEventListener('click', function () {
                        // modal component expects the event detail to be the modal name string
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-product-modal' }));
                    });
                }
            });
        </script>
        @if ($errors->any())
            <script>
                // If validation errors exist, open the create modal so user can see them
                document.addEventListener('DOMContentLoaded', function () {
                    // match the same event shape used elsewhere (detail is a string)
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-product-modal' }));
                });
            </script>
        @endif
    @endpush
@endsection
