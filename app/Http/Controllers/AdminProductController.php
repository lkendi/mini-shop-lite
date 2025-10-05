<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Create a new controller instance
     * with auth middleware for all routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List products
     */
       public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('description', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        switch ($request->input('sort')) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(8);
        $categories = Product::select('category')
            ->whereNotNull('category')
            ->pluck('category')
            ->map(function ($c) {
                return Str::title($c);
            })
            ->unique()
            ->values();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Return product JSON for JS
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Create a new product
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|integer|min:0',
            'category_select' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $category = null;
        if (!empty($validated['category_select']) && $validated['category_select'] !== '__other') {
            $category = $validated['category_select'];
        } elseif (!empty($validated['category'])) {
            $category = $validated['category'];
        }

        if ($category) {
            $category = Str::title($category);
        }

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category' => $category,
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
        ]);

        return redirect()->route('admin.products.index')
            ->with('status', 'success')
            ->with('message', 'Product created successfully.');
    }


    /**
     * Update an existing product
     */
    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_select' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $category = null;
        if (!empty($validated['category_select']) && $validated['category_select'] !== '__other') {
            $category = $validated['category_select'];
        } elseif (!empty($validated['category'])) {
            $category = $validated['category'];
        }
        if ($category) {
            $category = Str::title($category);
        }

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category' => $category ?? $product->category,
            'description' => $validated['description'] ?? $product->description,
            'image_url' => $validated['image_url'] ?? $product->image_url,
        ]);

        return redirect()->route('admin.products.index')
            ->with('status', 'success')
            ->with('message', 'Product updated successfully.');
    }



    /**
     * Delete a product
     */
    public function destroy(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('status', 'success')
            ->with('message', 'Product deleted successfully.');
    }
}
