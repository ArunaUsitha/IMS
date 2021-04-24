<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\ProductCategory;
use App\Stock;
use App\SystemCode;
use App\Warranty;
use Auth;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {


        return view('admin.products.overview');

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllProductsNCategories()
    {
        $productsWithCategories = Product::with('productCategory', 'brand')->get();
        return response()->json($productsWithCategories);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProductStatus(Request $request)
    {

        $productID = $request->post('id');
        $status = $request->post('status');

        $product = Product::find($productID);

        $product->status = $status;

        try {

            $product->save();

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }


        activity()->by(Auth::id())->log('set the status of the product to' . $status . 'of the product ID ' . $productID);

        $status = ($status) == 1 ? 'Product Activated' : 'Product Deactivated';

        return response()->json(self::getJSONResponse(
            true,
            'toast'
            , $status,
            ''
        ));


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeProduct(Request $request)
    {
//        //  $this->authorize('create', Auth::user());

        $product = new Product();

        $request->validate([
            'product_code' => 'required',
            'c_product_code' => 'required',
            'product_name' => 'required',
            'p_category_id' => 'required',
            'brand_id' => 'required',
            'reorder_point' => 'regex:/^[0-9]+$/',
            'reorder_quantity' => 'regex:/^[0-9]+$/'
        ]);

        $status = $request->post('productStatus');
        $status = ($status == null) ? 0 : 1;

        try {
            $product->code = $request->product_code;
            $product->custom_code = $request->c_product_code;
            $product->name = $request->product_name;
            $product->product_category_id = $request->p_category_id;
            $product->brand_id = $request->brand_id;
            $product->model_no = $request->model_no;
            $product->description = $request->descrip;
            $product->reorder_point = $request->reorder_point;
            $product->reorder_quantity = $request->reorder_quantity;
            $product->status = $status;

            $product->save();

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }


        activity()->by(Auth::id())->log('Used quick update to update the Supplier with ID ' . $product->id);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Product was added successfully..!',
            ''
        ));
    }


    /**
     * @param Request $request
     * @return
     */
    public function storeBrand(Request $request)
    {
        $brand = new Brand();

        $brand->name = $request->post('brand_name');


        Try {
            $brand->save();

        } catch (Exception $e) {

            $message = $e->getMessage();
            return response()->json(self::getJSONResponse(
                false,
                'header',
                $message,
                ''
            ));
        }


        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! Brand was Added.!',
            ''

        ));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCategory(Request $request)
    {
        $ProductCategory = new ProductCategory();

        $ProductCategory->name = $request->post('category_name');


        Try {
            $ProductCategory->save();

        } catch (Exception $e) {

            $message = $e->getMessage();
            return response()->json(self::getJSONResponse(
                false,
                'header',
                $message,
                ''
            ));
        }


        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! Category was Added.!',
            ''

        ));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBrands()
    {
        $brands = Brand::all();

        return response()->json($brands);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPoductCategories()
    {
        $ProductCategories = ProductCategory::all();

        return response()->json($ProductCategories);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProducts(Request $request)
    {
        $searchTerm = $request->get('name');
        if ($searchTerm !== '') {


            $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('code', '=', $searchTerm)
                ->orWhere('custom_code', '=', $searchTerm)
                ->where('status', '=', 1)
                ->get(['id', 'name'])->toJson();

            return response()->json(array('results' => $products));
        }
    }


    public function searchProductsForSale(Request $request)
    {


        $searchTerm = $request->get('name');

        if ($searchTerm !== '') {


            $products = DB::table('products')
                ->join('stocks', 'products.id', '=', 'stocks.product_id')
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                ->where('products.status', '=', 1)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('stocks.stock', '>', 0)
//                        ->orWhere('products.code', '=', $searchTerm)
//                        ->orWhere('products.custom_code', '=', $searchTerm)
//                        ->orWhere('products.name', 'LIKE', '%' . $searchTerm)
                        ->orWhere('product_categories.name', 'LIKE', '%' . $searchTerm);
                })->get(['products.id', 'products.name'])->toJson();

            return response()->json(array('results' => $products));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductByID(Request $request)
    {
        $searchTerm = $request->get('id');
        if ($searchTerm !== '') {

            $products = Product::where('id', '=', $searchTerm)
                ->where('status', '=', 1)
                ->get()->toJson();

            return response()->json(array('results' => $products));
        }
        return response()->json(array('results' => ''));
    }

    public function getProductDetails(Request $request)
    {
        $searchTerm = $request->get('id');
        if ($searchTerm !== '') {

            $products = DB::table('products')->join('purchase_products', 'products.id', '=', 'purchase_products.product_id')
                ->where('products.id', '=', $searchTerm)
                ->get()->toJson();

            return response()->json(array('results' => $products));
        }
        return response()->json(array('results' => ''));
    }

    public function warrantyManagementOverview()
    {
        $warranties = Warranty::all();
        return view('admin.products.warranty_management')->with('warranties', $warranties);
    }

    public function getNewProductCode()
    {
        $sysCode = new SystemCode();
        return response()->json($sysCode->getNewProductCode());
    }

    public function checkStock(Request $request){
        $itemid = $request->get('item_id');
        if ($itemid){

            $quantity = DB::select(DB::raw('SELECT s.stock FROM stocks s WHERE s.product_id = '.$itemid));

            return response()->json($quantity);
        }
    }
}
