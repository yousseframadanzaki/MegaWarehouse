<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\admin\CompnayController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientGroupController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingCompanyController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\MarketerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\TestController;

Route::get('/',function (){
    if(auth()->user()->is_admin){
        return redirect()->route('admin_dashboard');
    }
    return redirect()->route('dashboard');
})->middleware('auth');


Route::group(['prefix' => 'auth', 'middleware' => ['guest']],function () {
    Route::get('/login', [AuthenticationController::class,'login_form'])->name('login');
    Route::post('/login', [AuthenticationController::class,'login']);
});

Route::post('/logout', [AuthenticationController::class,'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','IsAdmin']],function () {

    Route::get('/',[AdminController::class,'index'])->name('admin_dashboard');

    Route::get('/companies', [CompnayController::class,'all'])->name('all_companies');
    Route::get('/companies/add', [CompnayController::class,'create'])->name('add_company');
    Route::post('/companies/add', [CompnayController::class,'store'])->name('store_company');
    Route::get('/companies/{company_id}/activate', [CompnayController::class,'activate'])->name('activate_company');
    Route::get('/companies/{company_id}/deactivate', [CompnayController::class,'deactivate'])->name('deactivate_company');
    Route::get('/companies/{company_id}/edit', [CompnayController::class,'edit'])->name('edit_company');
    Route::post('/companies/{company_id}/edit', [CompnayController::class,'update'])->name('update_company');
    Route::post('/login_as_user',[AdminController::class,'login_as_user'])->name('login_as_user');
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth','IsNotAdmin']],function () {

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');


    Route::get('/transactions', [AccountingController::class,'all'])
    ->name('all_transactions')
    ->can('view_transactions', 'App\Models\Transaction');

    Route::get('/transactions/add', [AccountingController::class, 'create'])
    ->name('add_transaction')
    ->can('add_transaction', 'App\Models\Transaction');

    Route::post('/transactions/add', [AccountingController::class, 'store'])
    ->name('store_transaction');

    Route::get('/invoices', [InvoiceController::class,'all'])
    ->name('all_invoices');
    Route::get('/invoices/{invoice_id}', [InvoiceController::class,'show'])
    ->name('show_invoice');
    Route::post('/invoices/{invoice_id}/pay', [InvoiceController::class,'pay'])
    ->name('pay_invoice');

    Route::get('/templates', [TemplateController::class,'all'])
    ->name('all_templates')
    ->can('view','App\Models\Template');

    Route::get('/templates/add', [TemplateController::class,'create'])
    ->name('add_template')
    ->can('add','App\Models\Template');

    Route::post('/templates/add', [TemplateController::class,'store'])
    ->name('store_template')
    ->can('add','App\Models\Template');

    Route::get('/templates/{template_id}/edit', [TemplateController::class,'edit'])
    ->name('edit_template')
    ->can('update',['App\Models\Template','template_id']);

    Route::post('/templates/{template_id}/edit', [TemplateController::class,'update'])
    ->name('update_template')
    ->can('update',['App\Models\Template','template_id']);




    Route::get('/shipping_companies', [ShippingCompanyController::class,'all'])
    ->name('all_shipping_companies')
    ->can('view','App\Models\ShippingCompany');

    Route::get('/shipping_companies/add', [ShippingCompanyController::class,'create'])
    ->name('add_shipping_company')
    ->can('add','App\Models\ShippingCompany');

    Route::post('/shipping_companies/add', [ShippingCompanyController::class,'store'])
    ->name('store_shipping_company')
    ->can('add','App\Models\ShippingCompany');

    Route::get('/shipping_companies/{shipping_company_id}', [ShippingCompanyController::class,'show'])
    ->name('show_shipping_company')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);

    Route::get('/shipping_companies/{shipping_company_id}/sectors', [ShippingCompanyController::class,'show_sectors'])
    ->name('show_shipping_company_sectors')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);

    Route::get('/shipping_companies/{shipping_company_id}/edit', [ShippingCompanyController::class,'edit'])
    ->name('edit_shipping_company')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);
    Route::post('/shipping_companies/{shipping_company_id}/edit', [ShippingCompanyController::class,'update'])
    ->name('update_shipping_company')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);

    Route::get('/shipping_companies/{shipping_company_id}/activate', [ShippingCompanyController::class,'activate'])
    ->name('activate_shipping_company')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);

    Route::get('/shipping_companies/{shipping_company_id}/deactivate', [ShippingCompanyController::class,'deactivate'])
    ->name('deactivate_shipping_company')
    ->can('update',['App\Models\ShippingCompany','shipping_company_id']);

    Route::get('/shipping_orders', [ShippingCompanyController::class,'shipping_orders'])
    ->name('shipping_orders')
    ->can('view_orders', 'App\Models\ShippingCompany');

    Route::post('/shipping_orders', [ShippingCompanyController::class,'shipping_company_statues'])
    ->name('shipping_orders_results');

    Route::get('/orders', [OrderController::class,'all'])
    ->name('all_orders')
    ->can('view','App\Models\Order');

    Route::get('/orders/add', [OrderController::class,'create'])
    ->name('add_order')
    ->can('add','App\Models\Order');

    Route::post('/orders/add', [OrderController::class,'store'])
    ->name('store_order')
    ->can('add','App\Models\Order');

    Route::get('/orders/{order_id}', [OrderController::class,'show'])
    ->name('show_order')
    ->can('view_one',['App\Models\Order','order_id']);

    Route::get('/orders/{order_id}/edit', [OrderController::class,'edit'])
    ->name('edit_order')
    ->can('edit_order',['App\Models\Order','order_id']);

    Route::post('/orders/{order_id}/edit', [OrderController::class,'update_order'])
    ->name('update_order')
    ->can('edit_order','App\Models\Order','order_id');

    Route::get('/orders/{order_id}/scan', [OrderController::class,'scan_order'])
    ->name('scan_order');
    //->can('scan_order',['App\Models\Order','order_id']);

    Route::post('/orders/{order_id}/scan', [OrderController::class,'confirm_order'])
    ->name('confirm_order');
    //->can('scan_order',['App\Models\Order','order_id']);

    Route::post('/orders/bulk/status', [OrderController::class,'change_status_bulk'])
    ->name('change_order_status_bulk')
    ->can('edit_change_status','App\Models\Order');

    Route::post('/orders/{order_id}/status', [OrderController::class,'change_status'])
    ->name('change_order_status')
    ->can('change_status',['App\Models\Order','order_id']);

    Route::post('/orders/{order_id}/print_order', [OrderController::class,'print_order'])
    ->name('print_order')
    ->can('print_order',['App\Models\Order','order_id']);

    Route::post('/orders/bulk/print', [OrderController::class,'print_orders'])
    ->name('print_orders')
    ->can('print_orders',['App\Models\Order']);

    Route::post('/orders/{order_id}/print_label', [OrderController::class,'print_label'])
    ->name('print_label')
    ->can('print_label',['App\Models\Order']);

    Route::post('/orders/bulk/print_labels', [OrderController::class,'print_labels'])
    ->name('print_labels')
    ->can('print_labels',['App\Models\Order']);

    Route::get('/stock', [StockController::class,'all'])
    ->name('all_stocks')
    ->can('view','App\\Models\Stock');

    Route::get('/stock/add', [StockController::class,'create'])
    ->name('add_stock')
    ->can('add','App\\Models\Stock');

    Route::post('/stock/add', [StockController::class,'store'])
    ->name('store_stock')
    ->can('add','App\\Models\Stock');

    Route::get('/stock/move', [StockController::class,'move'])
    ->name('move_stock')
    ->can('move','App\\Models\Stock');

    Route::post('/stock/move', [StockController::class,'store'])
    ->name('move_stock')
    ->can('move','App\\Models\Stock');

    Route::post('/stock/delete', [StockController::class,'delete'])
    ->name('delete_stock');

    Route::get('/package/add', [ProductController::class,'create_package'])
    ->name('add_package')
    ->can('add_package', 'App\Models\Product');

    Route::post('/package/add', [ProductController::class,'store_package'])
    ->name('add_package');

    Route::get('/products', [ProductController::class,'all'])
    ->name('all_products')
    ->can('view','App\Models\Product');

    Route::get('/products/add', [ProductController::class,'create'])
    ->name('add_product')
    ->can('add','App\Models\Product');

    Route::post('/products/add', [ProductController::class,'store'])
    ->name('store_product')
    ->can('add','App\Models\Product');

    Route::get('/products/{product_id}', [ProductController::class,'show'])
    ->name('show_product')
    ->can('view_one',['App\Models\Product','product_id']);

    Route::get('/products/{product_id}/edit', [ProductController::class,'edit'])
    ->name('edit_product')
    ->can('update',['App\Models\Product','product_id']);

    Route::post('/products/{product_id}/edit', [ProductController::class,'update'])
    ->name('update_product')
    ->can('update',['App\Models\Product','product_id']);

    Route::get('/products/{variant_id}/print', [ProductController::class,'print'])
    ->name('print_variant')
    ->can('print',['App\Models\Product','variant_id']);

    Route::get('/warehouses', [WarehouseController::class,'all'])
    ->name('all_warehouses')
    ->can('view','App\Models\Warehouse');

    Route::get('/warehouses/add', [WarehouseController::class,'create'])
    ->name('add_warehouse')
    ->can('add','App\Models\Warehouse');

    Route::post('/warehouses/add', [WarehouseController::class,'store'])
    ->name('store_warehouse')
    ->can('add','App\Models\Warehouse');

    Route::get('/warehouses/{warehouse_id}/edit', [WarehouseController::class,'edit'])
    ->name('edit_warehouse')
    ->can('update',['App\Models\Warehouse','warehouse_id']);

    Route::post('/warehouses/{warehouse_id}/edit', [WarehouseController::class,'update'])
    ->name('update_warehouse')
    ->can('update',['App\Models\Warehouse','warehouse_id']);


    Route::get('/suppliers', [SupplierController::class,'all'])
    ->name('all_suppliers')
    ->can('view','App\Models\Supplier');

    Route::get('/suppliers/add', [SupplierController::class,'create'])
    ->name('add_supplier')
    ->can('add','App\Models\Supplier');

    Route::post('/suppliers/add', [SupplierController::class,'store'])
    ->name('store_supplier')
    ->can('add','App\Models\Supplier');

    Route::get('/suppliers/{supplier_id}', [SupplierController::class,'show'])
    ->name('show_supplier');



    Route::get('/suppliers/{supplier_id}/edit', [SupplierController::class,'edit'])
    ->name('edit_supplier')
    ->can('update',['App\Models\Supplier','supplier_id']);

    Route::post('/suppliers/{supplier_id}/edit', [SupplierController::class,'update'])
    ->name('update_supplier')
    ->can('update',['App\Models\Supplier','supplier_id']);


    Route::get('/client_groups', [ClientGroupController::class,'all'])
    ->name('all_client_groups')
    ->can('view_clients','App\Models\ClientGroup');

    Route::get('/client_groups/add', [ClientGroupController::class,'create'])
    ->name('add_client_group')
    ->can('add_client_group','App\Models\ClientGroup');

    Route::post('/client_groups/add', [ClientGroupController::class,'store'])
    ->name('store_client_group')
    ->can('add_client_group','App\Models\ClientGroup');

    Route::get('/client_groups/{client_group_id}/edit', [ClientGroupController::class,'edit'])
    ->name('edit_client_group')
    ->can('update_client_group',['App\Models\ClientGroup','client_group_id']);

    Route::post('/client_groups/{client_group_id}/edit', [ClientGroupController::class,'update'])
    ->name('update_client_group')
    ->can('update_client_group',['App\Models\ClientGroup','client_group_id']);


    Route::get('/marketers', [MarketerController::class,'all'])
    ->name('all_marketers')
    ->can('view','App\Models\Marketer');

    Route::get('/marketers/add', [MarketerController::class,'create'])
    ->name('add_marketer')
    ->can('add','App\Models\Marketer');

    Route::post('/marketers/add', [MarketerController::class,'store'])
    ->name('store_marketer')
    ->can('add','App\Models\Marketer');

    Route::get('/marketers/{maeketer_id}/edit', [MarketerController::class,'edit'])
    ->name('edit_marketer')
    ->can('update_marketer',['App\Models\Marketer','maeketer_id']);

    Route::post('/marketers/{maeketer_id}/edit', [MarketerController::class,'update'])
    ->name('update_marketer')
    ->can('update',['App\Models\Marketer','maeketer_id']);


    Route::get('/clients', [ClientController::class,'all'])
    ->name('all_clients')
    ->can('view_clients','App\Models\Client');

    Route::get('/clients/add', [ClientController::class,'create'])
    ->name('add_client')
    ->can('add_client','App\Models\Client');

    Route::post('/clients/add', [ClientController::class,'store'])
    ->name('store_client')
    ->can('add_client','App\Models\Client');

    Route::get('/clients/{client_id}/edit', [ClientController::class,'edit'])
    ->name('edit_client')
    ->can('update_client',['App\Models\Client','client_id']);

    Route::post('/clients/{client_id}/edit', [ClientController::class,'update'])
    ->name('update_client')
    ->can('update_client',['App\Models\Client','client_id']);


    Route::get('/categories', [CategoryController::class,'all'])
    ->name('all_categories')
    ->can('view','App\Models\Category');


    Route::get('/categories/add', [CategoryController::class,'create'])
    ->name('add_category')
    ->can('add','App\Models\Category');

    Route::post('/categories/add', [CategoryController::class,'store'])
    ->name('store_category')
    ->can('add','App\Models\Category');

    Route::get('/categories/{category_id}', [CategoryController::class,'show'])
    ->name('show_category');

    Route::get('/categories/{category_id}/edit', [CategoryController::class,'edit'])
    ->name('edit_category')
    ->can('update',['App\Models\Category','category_id']);

    Route::post('/categories/{category_id}/edit', [CategoryController::class,'update'])
    ->name('update_category')
    ->can('update',['App\Models\Category','category_id']);


    Route::get('/brands', [BrandController::class,'all'])
    ->name('all_brands')
    ->can('view','App\Models\Brand');

    Route::get('/brands/add', [BrandController::class,'create'])
    ->name('add_brand')
    ->can('add','App\Models\Brand');

    Route::get('/brands/{brand_id}', [BrandController::class,'show'])
    ->name('show_brand');

    Route::post('/brands/add', [BrandController::class,'store'])
    ->name('store_brand')
    ->can('add','App\Models\Brand');

    Route::get('/brands/{brand_id}/edit', [BrandController::class,'edit'])
    ->name('edit_brand')
    ->can('update',['App\Models\Brand','brand_id']);

    Route::post('/brands/{brand_id}/edit', [BrandController::class,'update'])
    ->name('update_brand')
    ->can('update',['App\Models\Brand','brand_id']);


    Route::get('/roles', [RolesController::class,'all'])
    ->name('all_roles')
    ->can('view','App\Models\Role');

    Route::get('/roles/add', [RolesController::class,'create'])
    ->name('add_role')
    ->can('add','App\Models\Role');

    Route::post('/roles/add', [RolesController::class,'store'])
    ->name('store_role')
    ->can('add','App\Models\Role');

    Route::get('/roles/{role_id}/edit', [RolesController::class,'edit'])
    ->name('edit_role')
    ->can('update',['App\Models\Role','role_id']);

    Route::post('/roles/{role_id}/edit', [RolesController::class,'update'])
    ->name('update_role')
    ->can('update',['App\Models\Role','role_id']);


    Route::get('/users', [UsersController::class,'all'])
    ->name('all_users')
    ->can('view','App\Models\User');

    Route::get('/users/add', [UsersController::class,'create'])
    ->name('add_user')
    ->can('add','App\Models\User');

    Route::post('/users/add', [UsersController::class,'store'])
    ->name('store_user')
    ->can('add','App\Models\User');

    Route::get('/users/{user_id}/activate', [UsersController::class,'activate'])
    ->name('activate_user')
    ->can('activate_user_id',['App\Models\User','user_id']);

    Route::get('/users/{user_id}/deactivate', [UsersController::class,'deactivate'])
    ->name('deactivate_user')
    ->can('deactivate_user_id',['App\Models\User','user_id']);

    Route::get('/users/{user_id}/edit', [UsersController::class,'edit'])
    ->name('edit_user')
    ->can('view_one',['App\Models\User','user_id']);

    Route::post('/users/{user_id}/edit', [UsersController::class,'update'])
    ->name('update_user')
    ->can('update',['App\Models\User','user_id']);

    Route::get('/sectors',[AreaController::class,'all_sectors'])
    ->name('all_sectors')
    ->can('view',['App\Models\Area']);

    Route::get('sectors/add', [AreaController::class,'add_sector'])
    ->name('add_sector')
    ->can('add',['App\Models\Area']);

    Route::post('sectors/store', [AreaController::class,'store_sector'])
    ->name('store_sector');

    Route::post('orders/{order_id}/change_after_sale', [OrderController::class,'change_after_sale'])
    ->name('change_after_sale')
    ->can('add_discount',['App\Models\Order']);

    Route::get('statuses/settings', [StatusController::class,'statuses_settings'])
    ->name('all_statuses')
    ->can('view_statuses', ['App\Models\Status']);

    Route::get('campaign/add', [WhatsappController::class,'show_campaign'])
    ->name('show_campaign');

    Route::post('campaign/add', [WhatsappController::class,'store_campaign'])
    ->name('create_campaign');

    Route::get('whatsapp/campaigns', [WhatsappController::class,'all_campaign'])
    ->name('whatsapp_campaigns');

    Route::get('whatsapp/points/add', [WhatsappController::class,'add_points'])
    ->name('add_points');

    Route::post('whatsapp/points/add', [WhatsappController::class,'store_points'])
    ->name('store_whatsapp_points');

    Route::post('whatsapp/device/add', [WhatsappController::class,'add_device'])
    ->name('add_whatsapp_device');
});
