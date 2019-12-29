<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\PurchaseOrder;
use App\purchaseOrderProduct;
use App\purchaseProducts;
use App\stock;
use App\Supplier;
use App\SystemCode;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $suppliers = Supplier::where('status', '!=', 0)->get();

        return view('admin.purchase.create')->with('suppliers', $suppliers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @return Factory|View
     */
    public function GRNCreate()
    {
        return view('admin.purchase.grn_create');
    }


    public function getNewPurchaseOrderCode()
    {
        $sysCode = new SystemCode();
        return response()->json($sysCode->getNewPurchaseOrderCode());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function savePurchaseOrder(Request $request)
    {
        $supplierID = $request->post('supplierID');
        $orderCode = $request->post('order_code');
        $productsInfo = $request->post('prodcutInfo');

        if ($supplierID !== null) {

            DB::beginTransaction();

            $purchaseOrder = new PurchaseOrder();


            $purchaseOrder->order_code = $orderCode;
            $purchaseOrder->supplier_id = $supplierID;
            $purchaseOrder->save();
            try {

                foreach ($productsInfo as $productInfo) {
                    $purchaseOrderProduct = new purchaseOrderProduct();
                    $purchaseOrderProduct->purchase_order_id = $purchaseOrder->id;
                    $purchaseOrderProduct->product_id = $productInfo['itemID'];
                    $purchaseOrderProduct->quantity = $productInfo['quantity'];

                    $purchaseOrderProduct->save();

                }


            } catch (QueryException $e) {
                $errorMessage = $e->errorInfo[2];

                return response()->json(self::getJSONResponse(
                    false,
                    'header',
                    $errorMessage,
                    ''
                ));

                DB::rollback();
            }

            DB::commit();

            activity()->by(Auth::id())->log('Added purchase order for supplierID:' . $supplierID);

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Hooray..! Purchase order saved!!',
                ''

            ));


        }

    }


    public function saveGRN(Request $request)
    {
        $supplierID = $request->post('supplierID');
        $invoiceNo = $request->post('invoiceNo');
        $repName = $request->post('repName');

        $productsInfo = $request->post('productsInfo');

        if ($supplierID !== null) {

            try {

                DB::beginTransaction();


                $puchase = new Purchase();
                $puchase->invoice_no = $invoiceNo;
                $puchase->supplier_id = $supplierID;
                $puchase->sales_rep_name = $repName;

                $puchase->save();

                foreach ($productsInfo as $productInfo) {

                    $purchaseProduct = new purchaseProducts();

                    $purchaseProduct->purchase_id = $puchase->id;
                    $purchaseProduct->product_id = $productInfo['productID'];
                    $purchaseProduct->quantity = $productInfo['units'];
                    $purchaseProduct->buy_price = $productInfo['buyPrice'];
                    $purchaseProduct->sell_price = $productInfo['sellPrice'];
                    $purchaseProduct->warranty_period = $productInfo['warranty'];
                    $purchaseProduct->total = $productInfo['total'];

                    $units = $productInfo['units'];
                    $productID = $productInfo['productID'];

                    $purchaseProduct->save();


//                    $stocks = Stock::where('product_id', '=', $productInfo['productID'])->get();
//
//                    if (count($stocks) > 0) {
//
//                        Stock::where('product_id', '=', $productInfo['productID'])->update(['stock' => \DB::raw('stock +' . $units)]);
//                    }
//

                    Stock::updateOrCreate(
                        ['product_id' => $productID],['stock' => \DB::raw('stock +' . $units)]
                    );

                }


            } catch (QueryException $e) {
                $errorMessage = $e->errorInfo[2];

                return response()->json(self::getJSONResponse(
                    false,
                    'header',
                    $errorMessage,
                    ''
                ));

                DB::rollback();
            }

            DB::commit();

            activity()->by(Auth::id())->log('Added New GRN for supplierID:' . $supplierID);
            activity()->by(Auth::id())->log('Added New Stocks:' . $supplierID);

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Hooray..! GRN was saved!!',
                ''

            ));


        }
    }


}
