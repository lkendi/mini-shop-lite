<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display a list of customers for admin.
     */
    public function adminCustomersIndex(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('search') . '%');
        }

        switch ($request->input('sort')) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'email':
                $query->orderBy('email', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $customers = $query->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }


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
