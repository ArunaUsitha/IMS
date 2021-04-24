<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Exports\ReportExport;
use App\Supplier;
use App\SystemDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{

    private $companyName;
    private $companyAddress;
    private $companyPhone;

    function __construct()
    {
        $systemDetail = SystemDetail::find(1);
        $this->companyName = $systemDetail->company_name;
        $this->companyAddress = $systemDetail->company_address;
        $this->companyPhone = $systemDetail->company_phone;
    }

    public function overview()
    {
        $users = User::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();

        return view('admin.reports.reports_overview')->with(['users' => $users, 'suppliers' => $suppliers, 'customers' => $customers]);
    }

      private function printAsSelected($type, $title, $data, $view)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML(view($view)->with('data', $data))->setOption('title', $title);

        switch ($type) {
            case 'print':
                return $pdf->inline();
                break;
            case 'pdf':
                return $pdf->download($title . '.pdf');
                break;
            case 'excel':
                return Excel::download(new ReportExport($data, $view), $title . '.xlsx');
                break;
        }
    }

    public function generateUserActivityReport(Request $request)
    {

        if ($request->get('user_id') !== null) {

            $type = $request->get('type');

            $userID = $request->get('user_id');

            $activityLog = DB::table('activity_log')->where('causer_id', '=', $userID)->select('*', DB::raw('Date(created_at) as date'))->get();

            $userData = User::where('id', '=', $userID)->get();


            $data = array(
                'header_details' => array(
                    'company_name' => $this->companyName,
                    'company_address' => $this->companyAddress,
                    'company_phone' => $this->companyPhone,
                ),
                'user_data' => $userData[0],
                'activity_log' => $activityLog);

            $title = 'User Activity Report for : ' . $userID;
            $view = 'admin.reports.report_user_activity';

            return $this->printAsSelected($type, $title, $data, $view);

        }

    }


    public function generateSalesReport(Request $request)
    {
        $fromDate = $request->get('fromDate');
        $toDate = $request->get('toDate');

        $type = $request->get('type');

        if ($fromDate !== null && $toDate !== null) {

            $sales_data = DB::table('product_sales as ps')
                ->join('products as p', 'ps.product_id', '=', 'p.id')
                ->whereBetween(DB::raw('Date(ps.created_at)'), [$fromDate, $toDate])
                ->groupBy('ps.product_id', 'sold_date')
                ->select(DB::raw('p.code, p.name, Date(ps.created_at) as sold_date, sum(ps.quantity) as quantity'))
                ->get();

            $data = array(
                'header_details' => array(
                    'company_name' => $this->companyName,
                    'company_address' => $this->companyAddress,
                    'company_phone' => $this->companyPhone,
                ),
                'date_range' => ['fromDate' => $fromDate, 'toDate' => $toDate],
                'sales_data' => $sales_data);


            $title = 'sales report between : ' . $fromDate . ' to ' . $toDate;
            $view = 'admin.reports.report_sales_report';

            return $this->printAsSelected($type, $title, $data, $view);

        }

    }


    public function generateSupplierReport(Request $request)
    {
        $supplier_id = $request->get('supplier_id');

        $type = $request->get('type');

        if ($supplier_id !== null) {

            $supplier_info = DB::table('suppliers')->where('id', '=', $supplier_id)->get();

            $supplier_raw_data = DB::table('purchases as p')
                ->join('purchase_products as pp', 'p.id', '=', 'pp.purchase_id')
                ->join('products as pd', 'pp.product_id', '=', 'pd.id')
                ->select(DB::raw('pd.name,pd.code,p.invoice_no,p.sales_rep_name,date(p.created_at) AS Date,pp.product_id,pp.quantity,pp.buy_price,pp.sell_price,pp.warranty_period,pp.total '))
                ->where('p.supplier_id', '=', $supplier_id)
                ->get();


            $supplier_data = [];
            $oldInvoiceNO = null;

            foreach ($supplier_raw_data as $supplier) {
                if ($oldInvoiceNO == null) {
                    $oldInvoiceNO = $supplier->invoice_no;
                    $supplier_data[$supplier->invoice_no] = array();
                }

                if ($oldInvoiceNO !== $supplier->invoice_no) {
                    $supplier_data[$supplier->invoice_no] = array();
                }

                array_push($supplier_data[$supplier->invoice_no], $supplier);

            }


            $data = array(
                'header_details' => array(
                    'company_name' => $this->companyName,
                    'company_address' => $this->companyAddress,
                    'company_phone' => $this->companyPhone,
                ),
                'supplier_info' => $supplier_info[0],
                'supplier_data' => $supplier_data);


            $title = 'supplier report of supplier ID :' . $supplier_id;
            $view = 'admin.reports.report_supplier_report';

            return $this->printAsSelected($type, $title, $data, $view);


        }

    }


    public function generateCustomerWiseReport(Request $request)
    {

        $customer_id = $request->get('customer_id');

        $type = $request->get('type');

        if ($customer_id !== null) {

            $customer_info = DB::table('customers as c')
                ->where('c.id', '=', $customer_id)
                ->select(DB::raw("c.id, CONCAT_WS('',c.title,' ',c.initials,' ',c.first_name,' ',c.last_name) AS name,c.mobile, CONCAT(c.address_no,',',c.address_street,',',c.address_city) AS address"))
                ->get();

            $customer_sales_raw_data = DB::table('sales as s')
                ->join('product_sales as ps', 's.id', '=', 'ps.sales_id')
                ->join('products as p', 'p.id', '=', 'ps.product_id')
                ->select(DB::raw("s.invoice_no,s.amount,date(s.created_at) AS invoice_date,p.code,p.name,ps.price,ps.quantity,ps.total"))
                ->where('s.customer_id', '=', $customer_id)
                ->get();


            $customer_data = [];
            $oldInvoiceNO = null;

            foreach ($customer_sales_raw_data as $customer) {

                if ($oldInvoiceNO == null) {
                    $oldInvoiceNO = $customer->invoice_no;

                    $customer_data[$customer->invoice_no] = ['customer_data' => ['invoice_no' => $customer->invoice_no, 'amount' => $customer->invoice_date]];
                    $customer_data[$customer->invoice_no]['customer_sales_data'] = [];
                }

                if ($oldInvoiceNO !== $customer->invoice_no) {

                    $customer_data[$customer->invoice_no] = ['customer_data' => ['invoice_no' => $customer->invoice_no, 'amount' => $customer->invoice_date]];
                    $customer_data[$customer->invoice_no]['customer_sales_data'] = [];
                }


                array_push($customer_data[$customer->invoice_no]['customer_sales_data'], $customer);

            }


            $data = array(
                'header_details' => array(
                    'company_name' => $this->companyName,
                    'company_address' => $this->companyAddress,
                    'company_phone' => $this->companyPhone,
                ),
                'customer_info' => $customer_info[0],
                'customer_data' => $customer_data);


            $title = 'Customerwise Report for customer ID :' . $customer_id;
            $view = 'admin.reports.report_customerwise_report';

            return $this->printAsSelected($type, $title, $data, $view);

        }
    }

    public function generateStockReport(Request $request)
    {
        $type = $request->get('type');

        $stock_info = DB::table('stocks as s')
            ->join('products as p','s.product_id','=','p.id')
            ->where('p.status','=',1)
            ->get()->toArray();

        $data = array(
            'header_details' => array(
                'company_name' => $this->companyName,
                'company_address' => $this->companyAddress,
                'company_phone' => $this->companyPhone,
            ),
            'stock_info' => $stock_info);



        $title = 'Full Stock Report';
        $view = 'admin.reports.report_stock_report';

        return $this->printAsSelected($type, $title, $data, $view);


    }
}
