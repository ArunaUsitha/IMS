<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ProductSale;
use App\Reservation;
use App\Sale;
use App\Stock;
use App\SystemCode;
use App\SystemDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class salesController extends Controller
{
    private $salesQuoteData;


    public function newSalesOrder()
    {
        //get new sales order id
        $sysCode = new SystemCode();

//        $this->authorize('read',Sale::class);
        return view('admin.sales.new_sales_order')->with(['sales_order_no' => $sysCode->getNewSalesOrderNo()]);

    }

    public function customerCreate()
    {
//        $this->authorize('create', Sale::class);
        return view('admin.sales.customer_create');
    }

    public function customerStore(Request $request)
    {
//        $this->authorize('create', Sale::class);
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
            $customer->last_name = $request->post('last_name');
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
//        $this->authorize('read', Sale::class);
        return view('admin.sales.customer_overview');
    }

    public function getAllCustomers()
    {
//        $this->authorize('read', Sale::class);
        $customers = Customer::select('customers.*', DB::raw('DATE(`created_at`) as joined_date'))->get();

        return response()->json(['customers' => $customers]);
    }


    public function setCustomerStatus(Request $request)
    {
//        $this->authorize('update', Sale::class);
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
//        $this->authorize('update', Sale::class);
        $customerID = $request->get('id');

        $customers = Customer::find($customerID);

        return view('admin.sales.customer_create')->with(['customers' => $customers]);

    }

    public function customerUpdate(Request $request)
    {
//        $this->authorize('update', Sale::class);
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
            $customer->last_name = $request->post('last_name');
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
//        $this->authorize('read', Sale::class);
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
//        $this->authorize('read', Sale::class);
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

//        $this->authorize('read', Sale::class);
        if ($request->post('customerID') !== null) {

            DB::beginTransaction();
            try {
                $sale = new Sale();

                $sysCode = new SystemCode();
                $invoiceNo = $sysCode->getNewInvoiceNo();

                $customer_id = $request->post('customerID');
                $sales_order_no = $request->sales_order_no;

                $sale->customer_id = $customer_id;
                $sale->sales_order_id = $sales_order_no;
                $sale->amount = $request->post('total');
                $sale->invoice_no = $invoiceNo;


                $sale->save();

                $products = $request->post('productsInfo');

                foreach ($products as $product) {

                    $productSales = new ProductSale();

                    $product_id = $product['productID'];
                    $quantity = $product['quantity'];

                    $productSales->product_id = $product['productID'];
                    $productSales->sales_id = $sale->id;
                    $productSales->price = $product['price'];
                    $productSales->quantity = $product['quantity'];
                    $productSales->total = $product['total'];

                    //substract from stock
                    Stock::where('product_id', $product_id)
                        ->decrement('stock', $quantity);

                    $productSales->save();

                    Reservation::complete($sales_order_no, $sale->id, $product_id, $customer_id);

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

            $invoice_url = array('invoice_url' => Route('sales.generateInvoice') . '?salesID=' . $sale->id);

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Sale was success!!',
                $invoice_url

            ));


        }

    }


    public function generateInvoice(Request $request)
    {
//        $this->authorize('create', Sale::class);
        if ($request->get('salesID') !== null) {

            $salesID = $request->get('salesID');
            //get business details
            $company_name = SystemDetail::where('key', 'company_name')->select('value')->first();
            $company_address = SystemDetail::where('key', 'company_address')->select('value')->first();
            $company_phone = SystemDetail::where('key', 'company_phone')->select('value')->first();
            $companyName = $company_name->value;
            $companyAddress = $company_address->value;
            $companyPhone = $company_phone->value;

            $customerInfo = DB::table('sales')
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->where('sales.id', '=', $salesID)
                ->get();

            $salesInfo = DB::table('sales')
                ->join('product_sales', 'sales.id', '=', 'product_sales.sales_id')
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->join('products', 'product_sales.product_id', '=', 'products.id')
                ->join('purchase_products', 'products.id', '=', 'purchase_products.product_id')
                ->where('sales.id', '=', $salesID)
                ->select('*', DB::raw('product_sales.price as psPrice, product_sales.quantity as psQuantity, product_sales.total as psTotal'))
                ->get();


            $data = array(
                'header_details' => array(
                    'company_name' => $companyName,
                    'company_address' => $companyAddress,
                    'company_phone' => $companyPhone
                ),
                'customer_details' => $customerInfo[0],
                'sales_details' => $salesInfo);

            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML(view('admin.sales.invoice')->with('data', $data))->setOption('title', $data['customer_details']->invoice_no);
            return $pdf->inline();

        }
    }


    public function createNewSalesQuotation()
    {
//        $this->authorize('create', Sale::class);
        return view('admin.sales.new_sales_quotation');

    }


    public function triggerSalesQuotation(Request $request)
    {
//        $this->authorize('create', Sale::class);
        session(['salesQuoteData' => $request->all()]);


        $invoice_url = array('invoice_url' => Route('sales.generateSalesQuotation'));

        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $invoice_url

        ));


    }

    public function generateSalesQuotation()
    {
//        $this->authorize('create', Sale::class);
        if (session()->has('salesQuoteData')) {


            $request = session('salesQuoteData');


            $company_name = SystemDetail::where('key', 'company_name')->select('value')->first();
            $company_address = SystemDetail::where('key', 'company_address')->select('value')->first();
            $company_phone = SystemDetail::where('key', 'company_phone')->select('value')->first();
            $companyName = $company_name->value;
            $companyAddress = $company_address->value;
            $companyPhone = $company_phone->value;

            $data = array(
                'header_details' => array(
                    'company_name' => $companyName,
                    'company_address' => $companyAddress,
                    'company_phone' => $companyPhone,
                    'total' => $request['total']
                ),

                'sales_details' => $request['productsInfo']);


            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML(view('admin.sales.quotation')->with('data', $data))->setOption('title', 'sales Quotation');
            session()->forget('salesQuoteData');
            return $pdf->inline();
        }
    }


    public function getNewSalesOrderNo()
    {
        $sysCode = new SystemCode();
        return response()->json($sysCode->getNewSalesOrderNo());
    }


    public function makeReservation(Request $request)
    {

        $sales_order_no = $request->sales_order_no;
        $product_id = $request->product_id;
        $count = $request->count;
        $customer_id = $request->customer_id;

        try {

            Reservation::reserve($sales_order_no, $product_id, $count, $customer_id);

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));


        }

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            '',
            ''

        ));


    }

    public function cancelReservation(Request $request)
    {
//        product_id,customer_id

        $product_id = $request->product_id;
        $customer_id = $request->customer_id;

        if (Reservation::cancel($product_id, $customer_id)) {
            return response()->json(self::getJSONResponse(
                true,
                'header',
                '',
                ''
            ));
        } else {
            return response()->json(self::getJSONResponse(
                false,
                'header',
                '',
                ''
            ));
        }


    }

    public function salesOrdersOverview()
    {


        return view('admin.sales.overview');
    }

    public static function getSales()
    {

        try {

            $sales = Sale::select('*')
                ->join('customers', 'customers.id', '=', 'sales.customer_id')
                ->orderBy('sales.created_at', 'DESC')
                ->get()->toArray();

            if (count($sales) > 0) {
                return response()->json(self::getJSONResponse(
                    true,
                    'toast',
                    '',
                    $sales
                ));
            } else {
                return response()->json(self::getJSONResponse(
                    false,
                    'toast',
                    '',
                    ''
                ));
            }
        } catch (\Exception $e) {

        }

    }



    public function viewInvoice(Request $request){

        $invoice_no = $request->invoice_no;

        $company_name = SystemDetail::where('key', 'company_name')->select('value')->first();
        $company_address = SystemDetail::where('key', 'company_address')->select('value')->first();
        $company_phone = SystemDetail::where('key', 'company_phone')->select('value')->first();
        $companyName = $company_name->value;
        $companyAddress = $company_address->value;
        $companyPhone = $company_phone->value;

        $customerInfo = DB::table('sales')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->where('sales.invoice_no', '=', $invoice_no)
            ->get();

        $salesInfo = DB::table('sales')
            ->join('product_sales', 'sales.id', '=', 'product_sales.sales_id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->join('purchase_products', 'products.id', '=', 'purchase_products.product_id')
            ->where('sales.invoice_no', '=', $invoice_no)
            ->select('*', DB::raw('product_sales.price as psPrice, product_sales.quantity as psQuantity, product_sales.total as psTotal'))
            ->get();



        $data = array(
            'header_details' => array(
                'company_name' => $companyName,
                'company_address' => $companyAddress,
                'company_phone' => $companyPhone
            ),
            'customer_details' => $customerInfo[0],
            'sales_details' => $salesInfo);

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML(view('admin.sales.invoice')->with('data', $data))->setOption('title', $data['customer_details']->invoice_no);
        return $pdf->inline();

    }
}


