<?php

namespace App\Http\Controllers;

use App\purchaseProducts;
use App\Supplier;
use App\SystemCode;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Show full supplier overview
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {

        $suppliers = Supplier::all();

        return view('admin.suppliers.overview')->with(['suppliers' => $suppliers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
//        //  $this->authorize('create', Auth::user());

        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
//        //  $this->authorize('create', Auth::user());

        $request->validate([
            'supplier_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'Address' => 'required',
            'mobile' => 'required|min:10',
            'fixed_line' => 'required|min:10'
        ]);

        try {

            $supplier = new Supplier();

            $supplier->name = $request->supplier_name;
            $supplier->company_name = $request->company_name;
            $supplier->email = $request->email;
            $supplier->address = $request->Address;
            $supplier->mobile = $request->mobile;
            $supplier->fixed = $request->fixed_line;

            $supplier->save();


        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }

        activity()->by(Auth::id())->log('Created the Supplier with supplier ID '.  $supplier->id);
        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! A new Supplier was added!!',
            ''
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request)
    {
//        //  $this->authorize('read', Auth::user());

        $supplierID = $request->id;

        try {
//            //  $this->authorize('read', Auth::user());
            $supplier = Supplier::find($supplierID);

        } catch (Exception $e) {

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $e->getMessage(),
                ''
            ));
        }
        activity()->by(Auth::id())->log('Viewed the supplier edit for supplier ID '. $supplierID);
        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $supplier
        ));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request)
    {
//        //  $this->authorize('update', Auth::user());

        $supplierID = $request->id;

        $supplier = Supplier::find($supplierID);

        activity()->by(Auth::id())->log('Viewed the supplier edit for supplier ID '. $supplierID);

        return view('admin.suppliers.edit')->with(['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
//        //  $this->authorize('update', Auth::user());

        $supplier_id = $request->supplier_id;

        $supplier = Supplier::find($supplier_id);

        $request->validate([
            'supplier_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'Address' => 'required',
            'mobile' => 'required|min:10',
            'fixed_line' => 'required|min:10'
        ]);

        try {
            $supplier->name = $request->supplier_name;
            $supplier->company_name = $request->company_name;
            $supplier->email = $request->email;
            $supplier->address = $request->Address;
            $supplier->mobile = $request->mobile;
            $supplier->fixed = $request->fixed_line;

            $supplier->save();
        }catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }



        activity()->by(Auth::id())->log('Used quick update to update the Supplier with ID '.$supplier_id);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Supplier Deatails were updated!',
            ''
        ));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateQuick(Request $request)
    {
//        //  $this->authorize('update', Auth::user());

        $supplierID = $request->supplierID;
        $supplierStatus = $request->supplierStatus;
        $supplierApprove = $request->supplierApprove;


        $supplier = Supplier::find($supplierID);

        $supplierStatus = $supplierStatus == null ? 0 : $supplierStatus;
        $supplierApprove = ($supplier->is_approved) === 1 ? 1 : 1;

        try {

            $supplier->status = $supplierStatus;
            $supplier->is_approved = $supplierApprove;

            $supplier->save();

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }


        activity()->by(Auth::id())->log('Used quick update to update the Supplier with ID '.$supplierID);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'The Supplier was updated!',
            ''
        ));

    }

    public function searchSuppliers(Request $request){
//        //  $this->authorize('read', Auth::user());

        $searchTerm = $request->get('name');

        if ($searchTerm !== '') {


            $suppliers = Supplier::where('name', 'LIKE', '%'.$searchTerm.'%')
                ->where(function ($query)  use ($searchTerm){
                    $query->where('id','=','%'.$searchTerm)
                    ->orWhere('company_name','LIKE','%'.$searchTerm.'%');
                })

                ->where('status', '=', 1)
                ->where('is_approved', '=', 1)
                ->get(['id', 'name'])->toJson();

            return response()->json(array('results' => $suppliers));
        }

    }

    public function assignItems(Request $request){
        return view('admin.suppliers.assign_items');
    }


    public function viewOrderHistory(Request $request){
        return view('admin.suppliers.order_history');
    }

    public function getAllOrderHistories(Request $request){

//       $purchaseProducts =  purchaseProducts::all();

        $purchaseProducts = purchaseProducts::select('*')
           ->join('products','purchase_products.product_id','=','products.id')
           ->join('purchases','purchase_products.purchase_id','=','purchases.id')
           ->join('suppliers','purchases.supplier_id','=','suppliers.id')
           ->get();

        activity()->by(Auth::id())->log('Viewed the supplier order history');
        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $purchaseProducts
        ));
    }
}
