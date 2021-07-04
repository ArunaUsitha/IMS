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
Auth::routes();



Route::middleware(['auth:web'])->group(function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/', 'DashboardController@index')->name('dashboard');


    Route::get('/home', 'DashboardController@index')->name('dashboard');

//user routes



        Route::name('user.')->prefix('user')->middleware('auth')->group(function () {



            Route::get('getAuthData', 'UserController@getAuthData')->name('getAuthData');

            Route::middleware(['can:view_users'])->group(function () {
                Route::get('overview', 'UserController@index')->name('overview');
                Route::get('show', 'UserController@show')->name('show');
                Route::get('showUser', 'UserController@showUser')->name('showUser');

                Route::post('checkUserData', 'UserController@checkUserData')->name('checkUserData');
                Route::get('getAllUsersNRoles', 'UserController@getAllUsersNRoles')->name('getAllUsersNRoles');

            });


            Route::middleware(['can:create_user'])->group(function () {
                Route::get('create', 'UserController@create')->name('create');
                Route::post('store', 'UserController@store')->name('store');
            });

            Route::middleware(['can:modify_user'])->group(function () {

                Route::post('updateQuick', 'UserController@updateQuick')->name('updateQuick');
                Route::post('updateUser', 'UserController@updateUser')->name('updateUser');
                Route::post('updatePic', 'UserController@updatePic')->name('updatePic');
                Route::post('updatePass', 'UserController@updatePass')->name('updatePass');
                Route::get('edit', 'UserController@edit')->name('edit');
            });


        });


//supplier routes
        Route::name('supplier.')->prefix('supplier')->middleware('auth')->group(function () {

            Route::middleware(['can:view_suppliers'])->group(function () {
                Route::get('overview', 'SupplierController@overview')->name('overview');
                Route::get('show', 'SupplierController@show')->name('show');
                Route::get('searchSuppliers', 'SupplierController@searchSuppliers')->name('searchSuppliers');
            });


            Route::middleware(['can:modify_supplier'])->group(function () {
                Route::get('create', 'SupplierController@create')->name('create');
                Route::post('store', 'SupplierController@store')->name('store');
            });

            Route::middleware(['can:create_supplier'])->group(function () {
                Route::get('edit', 'SupplierController@edit')->name('edit');
                Route::post('update', 'SupplierController@update')->name('update');
                Route::post('updateQuick', 'SupplierController@updateQuick')->name('updateQuick');
            });

            Route::middleware(['can:view_order_history'])->group(function () {
                Route::get('viewOrderHistory', 'SupplierController@viewOrderHistory')->name('viewOrderHistory');
                Route::get('getAllOrderHistories', 'SupplierController@getAllOrderHistories')->name('getAllOrderHistories');
            });


//            Route::get('assignItems', 'SupplierController@assignItems')->name('assignItems');

        });


//product routes
        Route::name('product.')->prefix('product')->middleware('auth')->group(function () {

            Route::middleware(['can:view_products'])->group(function () {

                Route::get('overview', 'ProductController@overview')->name('overview');
                Route::get('searchProductsForSale', 'ProductController@searchProductsForSale')->name('searchProductsForSale');
                Route::get('getProductDetails', 'ProductController@getProductDetails')->name('getProductDetails');
                Route::get('searchProducts', 'ProductController@searchProducts')->name('searchProducts');
                Route::get('checkStock', 'ProductController@checkStock')->name('checkStock');
                Route::get('getPurchasedPricesByProductID', 'ProductController@getPurchasedPricesByProductID')->name('getPurchasedPricesByProductID');
                Route::get('getProductByID', 'ProductController@getProductByID')->name('getProductByID');

                Route::get('getAllBrands', 'ProductController@getAllBrands')->name('getAllBrands');
                Route::get('getAllPoductCategories', 'ProductController@getAllPoductCategories')->name('getAllPoductCategories');
                Route::get('getAllProductsNCategories', 'ProductController@getAllProductsNCategories')->name('getAllProductsNCategories');
            });


            Route::middleware(['can:add_product'])->group(function () {

                Route::get('create', 'ProductController@create')->name('create');

                Route::post('storeProduct', 'ProductController@storeProduct')->name('storeProduct');
                Route::post('storeBrand', 'ProductController@storeBrand')->name('storeBrand');
                Route::post('storeCategory', 'ProductController@storeCategory')->name('storeCategory');


//                Route::get('getAllBrands', 'ProductController@getAllBrands')->name('getAllBrands');
//                Route::get('getAllPoductCategories', 'ProductController@getAllPoductCategories')->name('getAllPoductCategories');
//                Route::get('getAllProductsNCategories', 'ProductController@getAllProductsNCategories')->name('getAllProductsNCategories');
                Route::get('getNewProductCode', 'ProductController@getNewProductCode')->name('getNewProductCode');
                Route::get('getProductPrice', 'ProductController@getProductPrice')->name('getProductPrice');

            });

            Route::middleware(['can:view_product_history'])->group(function () {
                Route::get('showProductHistory', 'ProductController@showProductHistory')->name('showProductHistory');

            });


            Route::middleware(['can:modify_product'])->group(function () {
                Route::post('setProductStatus', 'ProductController@setProductStatus')->name('setProductStatus');
                Route::post('updateProductDefaultPrice', 'ProductController@updateProductDefaultPrice')->name('updateProductDefaultPrice');
            });


            Route::get('warrantyManagementOverview', 'ProductController@warrantyManagementOverview')->name('warrantyManagementOverview');


        });


//Purchase Routes
        Route::name('purchase.')->prefix('purchase')->middleware('auth')->group(function () {


            Route::middleware(['can:create_purchase_order'])->group(function () {
                Route::get('create', 'PurchaseController@create')->name('create');
                Route::get('getNewPurchaseOrderCode', 'PurchaseController@getNewPurchaseOrderCode')->name('getNewPurchaseOrderCode');
                Route::post('savePurchaseOrder', 'PurchaseController@savePurchaseOrder')->name('savePurchaseOrder');
            });


            Route::middleware(['can:view_purchase_order'])->group(function () {
                Route::get('overview', 'PurchaseController@overview')->name('overview');
                Route::get('getAllPurchaseOrders', 'PurchaseController@getAllPurchaseOrders')->name('getAllPurchaseOrders');
                Route::get('showPurchaseOrder', 'PurchaseController@showPurchaseOrder')->name('showPurchaseOrder');
            });


            Route::middleware(['can:add_stock'])->group(function () {
                Route::get('GRNCreate', 'PurchaseController@GRNCreate')->name('GRNCreate');


                Route::post('saveGRN', 'PurchaseController@saveGRN')->name('saveGRN');

            });

        });


//Stock Routes
        Route::name('stock.')->prefix('stock')->middleware('auth')->group(function () {

            Route::middleware(['can:view_stock'])->group(function () {
                Route::get('viewStock', 'StockController@viewStock')->name('viewStock');
                Route::get('getAllStocks', 'StockController@getAllStocks')->name('getAllStocks');
            });

        });


//Sale Routes
        Route::name('sales.')->prefix('sales')->middleware('auth')->group(function () {


            //sales
            Route::middleware(['can:create_sales_order'])->group(function () {
                //reservations
                Route::post('makeReservation', 'SalesController@makeReservation')->name('makeReservation');

                Route::get('newSalesOrder', 'SalesController@newSalesOrder')->name('newSalesOrder');
                Route::post('storeSalesOrder', 'SalesController@storeSalesOrder')->name('storeSalesOrder');
                Route::get('generateInvoice', 'SalesController@generateInvoice')->name('generateInvoice');

            });


            //customers
            Route::middleware(['can:register_customer'])->group(function () {

                Route::get('customerCreate', 'SalesController@customerCreate')->name('customerCreate');
                Route::post('customerStore', 'SalesController@customerStore')->name('customerStore');
            });


            Route::middleware(['can:view_customer'])->group(function () {
                Route::get('customerOverview', 'SalesController@customerOverview')->name('customerOverview');
                Route::get('getAllCustomers', 'SalesController@getAllCustomers')->name('getAllCustomers');

                Route::get('searchCustomer', 'SalesController@searchCustomer')->name('searchCustomer');
                Route::get('getCustomerInfoByID', 'SalesController@getCustomerInfoByID')->name('getCustomerInfoByID');
            });


            Route::middleware(['can:modify_customer'])->group(function () {
                Route::post('setCustomerStatus', 'SalesController@setCustomerStatus')->name('setCustomerStatus');
                Route::get('customerShowEdit', 'SalesController@customerShowEdit')->name('customerShowEdit');
                Route::post('customerUpdate', 'SalesController@customerUpdate')->name('customerUpdate');
            });


            Route::middleware(['can:create_sales_quotation'])->group(function () {
                Route::get('createNewSalesQuotation', 'SalesController@createNewSalesQuotation')->name('createNewSalesQuotation');
                Route::post('triggerSalesQuotation', 'SalesController@triggerSalesQuotation')->name('triggerSalesQuotation');
                Route::get('generateSalesQuotation', 'SalesController@generateSalesQuotation')->name('generateSalesQuotation');
            });


            Route::middleware(['can:sales_overview'])->group(function () {
                Route::get('salesOrdersOverview', 'SalesController@salesOrdersOverview')->name('salesOrdersOverview');
                Route::get('getSales', 'SalesController@getSales')->name('getSales');
                Route::get('viewInvoice', 'SalesController@viewInvoice')->name('viewInvoice');
            });


        });


//Report Routes
        Route::name('reports.')->prefix('reports')->middleware('auth')->group(function () {


            Route::middleware(['can:view_reports'])->group(function () {


                Route::get('overview', 'ReportsController@overview')->name('overview');
                Route::get('overview', 'ReportsController@overview')->name('overview');

                //reports
                Route::get('generateUserActivityReport', 'ReportsController@generateUserActivityReport')->name('generateUserActivityReport');
                Route::get('generateSalesReport', 'ReportsController@generateSalesReport')->name('generateSalesReport');
                Route::get('generateSupplierReport', 'ReportsController@generateSupplierReport')->name('generateSupplierReport');
                Route::get('generateCustomerReport', 'ReportsController@generateCustomerReport')->name('generateCustomerReport');
                Route::get('generateCustomerWiseReport', 'ReportsController@generateCustomerWiseReport')->name('generateCustomerWiseReport');
                Route::get('generateStockReport', 'ReportsController@generateStockReport')->name('generateStockReport');

            });


        });

//System Settings Routes
        Route::name('settings.')->prefix('settings')->middleware('auth')->group(function () {


            Route::middleware(['can:role_management'])->group(function () {
                Route::get('userAdministrationOverview', 'SystemSettingsController@userAdministrationOverview')->name('userAdministrationOverview');
                Route::post('getUserModulesNPermissions', 'SystemSettingsController@getUserModulesNPermissions')->name('getUserModulesNPermissions');
                Route::post('getPermissions', 'SystemSettingsController@getPermissions')->name('getPermissions');
                Route::post('updatePermission', 'SystemSettingsController@updatePermission')->name('updatePermission');
                Route::post('storeNewModule', 'SystemSettingsController@storeNewModule')->name('storeNewModule');
                Route::post('storeNewUserRole', 'SystemSettingsController@storeNewUserRole')->name('storeNewUserRole');

                Route::get('getRoles', 'SystemSettingsController@getRoles')->name('getRoles');
                Route::get('editRolePermissions/{roleID}', 'SystemSettingsController@editRolePermissions')->name('editRolePermissions');
                Route::post('updateRolePermissions', 'SystemSettingsController@updateRolePermissions')->name('updateRolePermissions');
                Route::get('showCreateNewRoleView', 'SystemSettingsController@showCreateNewRoleView')->name('showCreateNewRoleView');
                Route::post('createNewRole', 'SystemSettingsController@createNewRole')->name('createNewRole');
                Route::post('deleteRole', 'SystemSettingsController@deleteRole')->name('deleteRole');

            });

        });

    });


Route::post('cancelReservation', 'SalesController@cancelReservation')->name('cancelReservation');

Route::middleware('auth')->get('logout', function () {
    Auth::logout();
    return redirect(route('login'))->withInfo('You have successfully logged out!');
})->name('logout');


Route::get('test', function () {

    Log::info('notification event test');
    event(new \App\Events\SendLowStockNotification('test message'));
    return "Event has been sent!";
});

