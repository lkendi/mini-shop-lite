<div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
    <!-- Image Container -->
    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100 dark:bg-gray-700">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-48 flex items-center justify-center">
                <x-heroicon-o-photo class="w-12 h-12 text-gray-400 dark:text-gray-500" />
            </div>
        @endif
        
        <!-- Stock Badge -->
        <div class="absolute top-3 right-4">
            @if($product->stock > 0)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200' }}">
                    {{ $product->stock > 10 ? 'In Stock' : 'Low Stock' }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                    Out of Stock
                </span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 flex flex-col flex-grow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2 mb-2">
            <a href="{{ route('products.show', $product) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                {{ $product->name }}
            </a>
        </h3>
        
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 flex-grow mb-4">
            {{ $product->description ? Str::limit($product->description, 80) : 'No description available.' }}
        </p>

        <div class="flex items-center justify-between mt-auto">
            <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
            
            @if($product->category)
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                    {{ $product->category }}
                </span>
            @endif
        </div>
    </div>

    <div class="px-4 pb-6">
        @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-4 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 text-sm font-medium flex items-center justify-center group/btn">
                    <x-heroicon-o-shopping-cart class="w-4 h-4 mr-2 group-hover/btn:scale-110 transition-transform" />
                    Add to Cart
                </button>
            </form>
        @endif
    </div>
</div>
