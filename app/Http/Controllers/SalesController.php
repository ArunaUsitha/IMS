<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ProductSales;
use App\Sale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class salesController extends Controller
{
    public function newSalesOrder()
    {

        return view('admin.sales.new_sales_order');

    }

    public function customerCreate()
    {
        return view('admin.sales.customer_create');
    }

    public function customerStore(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'initials' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|min:10',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city' => 'required'
        ]);

        try {


            $customer = new Customer();

            $customer->title = $request->post('title');
            $customer->initials = $request->post('initials');
            $customer->first_name = $request->post('first_name');
            $customer->gender = $request->post('gender');
            $customer->mobile = $request->post('mobile');
            $customer->address_no = $request->post('address_no');
            $customer->address_street = $request->post('address_street');
            $customer->address_city = $request->post('address_city');
            $customer->email = $request->post('email');

            $customer->save();

            $customerID = $customer->id;
        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }

        activity()->by(Auth::id())->log('Registered a new customer with customer ID : ' . $customerID);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! The Customer was registered!!',
            ''
        ));
    }


    public function customerOverview()
    {
        return view('admin.sales.customer_overview');
    }

    public function getAllCustomers()
    {
        $customers = Customer::select('customers.*', DB::raw('DATE(`created_at`) as joined_date'))->get();

        return response()->json(['customers' => $customers]);
    }


    public function setCustomerStatus(Request $request)
    {
        $customerID = $request->post('id');
        $status = $request->post('status');

        $customer = Customer::find($customerID);

        $customer->status = $status;

        try {

            $customer->save();

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }


        activity()->by(Auth::id())->log('set the status of the customer to' . $status . 'of the customer ID ' . $customerID);

        $status = ($status) == 1 ? 'Customer Activated' : 'Customer Deactivated';

        return response()->json(self::getJSONResponse(
            true,
            'toast'
            , $status,
            ''
        ));
    }

    public function customerShowEdit(Request $request)
    {
        $customerID = $request->get('id');

        $customers = Customer::find($customerID);

        return view('admin.sales.customer_create')->with(['customers' => $customers]);

    }

    public function customerUpdate(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'initials' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|min:10',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city' => 'required'
        ]);

        try {

            $customerID = $request->post('customer_id');

            $customer = Customer::find($customerID);

            $customer->title = $request->post('title');
            $customer->initials = $request->post('initials');
            $customer->first_name = $request->post('first_name');
            $customer->gender = $request->post('gender');
            $customer->mobile = $request->post('mobile');
            $customer->address_no = $request->post('address_no');
            $customer->address_street = $request->post('address_street');
            $customer->address_city = $request->post('address_city');
            $customer->email = $request->post('email');

            $customer->save();


        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }

        activity()->by(Auth::id())->log('Updated customer info of customer ID : ' . $customerID);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! The Customer was Updated!!',
            ''
        ));
    }


    public function searchCustomer(Request $request)
    {
        $searchTerm = $request->get('name');

        if ($searchTerm !== '') {


            $customers = Customer::where('status', '=', 1)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('mobile', 'LIKE', '%' . $searchTerm);
                })->get(['id', 'first_name'])->toJson();


            return response()->json(array('results' => $customers));
        }

    }

    public function getCustomerInfoByID(Request $request)
    {
        $customer_id = $request->post('id');

        $customers = Customer::where('id', '=', $customer_id)
            ->where('status', '=', 1)
            ->select('id', 'mobile', 'first_name', DB::raw('CONCAT(address_no, ", ", address_street, ", ", address_city) AS address'))
            ->get();

        if (count($customers) > 0) {
            return response()->json(self::getJSONResponse(
                true,
                'toast',
                '',
                $customers
            ));
        } else {
            return response()->json(self::getJSONResponse(
                false,
                'toast',
                '',
                ''
            ));
        }
    }

    public function storeSalesOrder(Request $request)
    {


        if ($request->post('customerID') !== null) {

            DB::beginTransaction();
            try {
                $sale = new Sale();

                $sale->customer_id = $request->post('customerID');
                $sale->amount = $request->post('total');

                $sale->save();

                $products = $request->post('productsInfo');

                foreach ($products as $product) {

                    $productSales = new ProductSales();

                    $productSales->product_id = $product['productID'];
                    $productSales->price = $product['price'];
                    $productSales->quantity = $product['quantity'];
                    $productSales->total = $product['total'];

                    $productSales->save();

                }

            } catch (QueryException $e) {
                $errorMessage = $e->errorInfo[2];

                DB::rollback();

                return response()->json(self::getJSONResponse(
                    false,
                    'header',
                    $errorMessage,
                    ''
                ));


            }

            DB::commit();

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Sale was success!!',
                ''

            ));


        }

    }

}


