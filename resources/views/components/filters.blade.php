@props([
    'action' => url()->current(),
    'categories' => []
])

@php
use Illuminate\Support\Str;

$cats = collect($categories)->map(function ($c) {
    if (is_string($c)) return $c;
    if (is_object($c) && isset($c->category)) return $c->category;
    if (is_array($c) && isset($c['category'])) return $c['category'];
    return (string) $c;
})->filter()->unique()->values();
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
    <form action="{{ $action }}" method="GET" class="grid grid-cols-1 md:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-center">
        <div>
            <div class="relative">
                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400 absolute left-3 top-2.5 pointer-events-none" />
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search..." oninput="debounce(this.form)">
            </div>
        </div>

        <div>
            <select name="category" id="category" onchange="this.form.submit()"
                    class="block w-full py-2 px-3 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                @foreach($cats as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="sort" id="sort" onchange="this.form.submit()"
                    class="block w-full py-2 px-3 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
            </select>
        </div>

        <div class="flex justify-center">
            <a href="{{ $action }}" class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-center">
                Clear
            </a>
        </div>
    </form>
</div>

@once
@push('scripts')
<script>
    let __searchTimeout;
    function debounce(form, delay = 200) {
        clearTimeout(__searchTimeout);
        __searchTimeout = setTimeout(() => form.submit(), delay);
    }
</script>
@endpush
@endonce
