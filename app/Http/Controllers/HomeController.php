<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }
    public function dashboard()
    {
        $user = auth()->user();
        $role = $user->role;

        $myOrdersQuery = Order::with('items.product');

        if ($role && $role->isStaff())
        {
            $myOrdersQuery->where('business_id', $user->business_id);
        }
        else
        {
            $myOrdersQuery->where('user_id', $user->id);
        }

        // Calculate total before pagination
        $totalPurchaseCost = $myOrdersQuery->sum('total');

        // Then paginate results
        $myOrders = $myOrdersQuery->paginate(3);

        $allOrders = [
            'totalCost' => $totalPurchaseCost,
            'myorders'  => $myOrders
        ];

        return view('home.dashboard', compact('allOrders'));
    }
}
