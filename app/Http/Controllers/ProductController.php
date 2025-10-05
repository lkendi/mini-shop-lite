<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{    
    /**
     * Sets up middleware for the controller to ensure auth
     * for all routes except welcome and index.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome', 'index']);
    }

    /**
     * Display the welcome page with featured products (8 random products).
     */
    public function welcome()
    {
        $featuredProducts = Product::where('stock', '>', 0)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $categories = Product::select('category')
            ->whereNotNull('category')
            ->pluck('category')
            ->map(function ($c) {
                return Str::title($c);
            })
            ->unique()
            ->values();

        return view('welcome', compact('featuredProducts', 'categories'));
    }
 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

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

        $products = $query->paginate(12);
        $categories = Product::select('category')
            ->whereNotNull('category')
            ->pluck('category')
            ->map(function ($c) {
                return Str::title($c);
            })
            ->unique()
            ->values();

        return view('products.index', compact('products', 'categories'));
    }

}