<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with key metrics.
     */
    public function index()
    {
        $totalCustomers = User::where('role', User::ROLE_CUSTOMER)->count();
        $totalProducts = Product::count();
        $productsByCategory = Product::select('category', DB::raw('count(*) as product_count'))
                                ->groupBy('category')
                                ->get();

        //TODO: Add orders table
        $totalSales = 0;
        $newOrders = 0; 
        $salesByCategory = Product::select('category', DB::raw('SUM(price) as total_sales'))
                                ->groupBy('category')
                                ->get();
       

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalSales',
            'newOrders',
            'totalCustomers',
            'productsByCategory',
            'salesByCategory'
        ));
    }
}
