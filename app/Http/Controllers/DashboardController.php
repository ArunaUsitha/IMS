<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {

        //total orders
        $totalOrders = Sale::count();

        $totalCustomers = Customer::count();

        $today = date('Y-m-d');

        $ordersToday = DB::table('sales as s')
            ->select(DB::raw('COUNT(s.id) as count'))
            ->where(DB::raw('DATE(s.created_at)'), '=', $today)
            ->get()->toArray();

        $topProducts = DB::select(DB::raw('SELECT p.id,p.code,p.name,SUM(ps.quantity) AS sales FROM product_sales ps
                                              INNER JOIN products p ON ps.product_id = p.id
                                              GROUP BY p.id,p.code,p.name ORDER BY sales DESC LIMIT 5'));

        $latestAddedProducts = DB::select(DB::raw('SELECT p.code,p.name,p.brand_id,p.model_no,b.name AS brand_name FROM products p
                                              INNER JOIN stocks s ON s.product_id = p.id
                                              INNER JOIN brands b ON b.id = p.brand_id
                                              ORDER BY s.created_at DESC limit 10'));


        $data = [
            'total_orders' => $totalOrders,
            'total_customers' => $totalCustomers,
            'orders_today' => $ordersToday[0],
            'top_products' => $topProducts,
            'latest_added_products' => $latestAddedProducts
        ];

        if (Auth::check()) {
            return view('admin.dashboard.index')->with('data', $data);
        } else {
            return redirect('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
