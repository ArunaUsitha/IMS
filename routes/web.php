<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::post('/login', [
//    'uses'          => 'Auth\AuthController@login',
//    'middleware'    => 'checkStatus',
//]);


Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/', 'DashboardController@index')->name('dashboard');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//user routes
Route::name('user.')->prefix('user')->middleware('auth')->group(function() {
    Route::get('overview','UserController@index')->name('overview');
    Route::get('create', 'UserController@create')->name('create');
    Route::post('store','UserController@store')->name('store');
    Route::get('show','UserController@show')->name('show');
    Route::get('showUser','UserController@showUser')->name('showUser');
    Route::post('updateQuick','UserController@updateQuick')->name('updateQuick');
    Route::post('updateUser','UserController@updateUser')->name('updateUser');
    Route::post('updatePic','UserController@updatePic')->name('updatePic');
    Route::post('updatePass','UserController@updatePass')->name('updatePass');
    Route::get('edit','UserController@edit')->name('edit');

    //other routes
    Route::post('checkUserData','UserController@checkUserData')->name('checkUserData');
    Route::get('getAllUsersNRoles','UserController@getAllUsersNRoles')->name('getAllUsersNRoles');

    //get auth data
    Route::get('getAuthData','UserController@getAuthData')->name('getAuthData');


});

//supplier routes
Route::name('supplier.')->prefix('supplier')->middleware('auth')->group(function (){
    Route::get('overview','SupplierController@overview')->name('overview');
    Route::get('create','SupplierController@create')->name('create');
    Route::post('store','SupplierController@store')->name('store');
    Route::get('edit','SupplierController@edit')->name('edit');
    Route::post('update','SupplierController@update')->name('update');
    Route::post('updateQuick','SupplierController@updateQuick')->name('updateQuick');
    Route::get('show','SupplierController@show')->name('show');
    Route::get('assignItems','SupplierController@assignItems')->name('assignItems');
    Route::get('searchSuppliers','SupplierController@searchSuppliers')->name('searchSuppliers');
});


//product routes
Route::name('product.')->prefix('product')->middleware('auth')->group(function (){
    Route::get('overview','ProductController@overview')->name('overview');
    Route::get('create','ProductController@create')->name('create');
    Route::post('storeProduct','ProductController@storeProduct')->name('storeProduct');
    Route::post('storeBrand','ProductController@storeBrand')->name('storeBrand');
    Route::post('storeCategory','ProductController@storeCategory')->name('storeCategory');

    //Ajax routes
    Route::get('getAllBrands','ProductController@getAllBrands')->name('getAllBrands');
    Route::get('getAllPoductCategories','ProductController@getAllPoductCategories')->name('getAllPoductCategories');
    Route::get('getAllProductsNCategories','ProductController@getAllProductsNCategories')->name('getAllProductsNCategories');
    Route::get('getNewProductCode','ProductController@getNewProductCode')->name('getNewProductCode');
    Route::post('setProductStatus','ProductController@setProductStatus')->name('setProductStatus');
    Route::get('searchProducts','ProductController@searchProducts')->name('searchProducts');
    Route::get('getProductByID','ProductController@getProductByID')->name('getProductByID');
    Route::get('warrantyManagementOverview','ProductController@warrantyManagementOverview')->name('warrantyManagementOverview');
});


//Purchase Routes
Route::name('purchase.')->prefix('purchase')->middleware('auth')->group(function (){
    Route::get('create','PurchaseController@create')->name('create');
    Route::get('overview','PurchaseController@overview')->name('overview');
    Route::get('GRNCreate','PurchaseController@GRNCreate')->name('GRNCreate');
    Route::get('getNewPurchaseOrderCode','PurchaseController@getNewPurchaseOrderCode')->name('getNewPurchaseOrderCode');
    Route::post('savePurchaseOrder','PurchaseController@savePurchaseOrder')->name('savePurchaseOrder');
    Route::post('saveGRN','PurchaseController@saveGRN')->name('saveGRN');
});


//Stock Routes
Route::name('stock.')->prefix('stock')->middleware('auth')->group(function (){
    Route::get('viewStock','StockController@viewStock')->name('viewStock');
    Route::get('getAllStocks','StockController@getAllStocks')->name('getAllStocks');

});


//Stock Routes
Route::name('sales.')->prefix('sales')->middleware('auth')->group(function (){
    Route::get('newSale','SalesController@newSale')->name('newSale');
    Route::get('newCustomer','SalesController@newCustomer')->name('newCustomer');

});




Route::middleware('auth')->get('logout', function() {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');
