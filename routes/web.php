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
    
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth','IsNotAdmin']],function () {

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

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

    Route::get('/suppliers/{supplier_id}/edit', [SupplierController::class,'edit'])
    ->name('edit_supplier')
    ->can('update',['App\Models\Supplier','supplier_id']);

    Route::post('/suppliers/{supplier_id}/edit', [SupplierController::class,'update'])
    ->name('update_supplier')
    ->can('update',['App\Models\Supplier','supplier_id']);


    Route::get('/client_groups', [ClientGroupController::class,'all'])
    ->name('all_client_groups')
    ->can('view_client_group','App\Models\ClientGroup');

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
    ->can('update',['App\Models\Client','client_id']);

    Route::post('/clients/{client_id}/edit', [ClientController::class,'update'])
    ->name('update_client')
    ->can('update',['App\Models\Client','client_id']);


    Route::get('/categories', [CategoryController::class,'all'])
    ->name('all_categories')
    ->can('view','App\Models\Categroy');

    Route::get('/categories/add', [CategoryController::class,'create'])
    ->name('add_category')
    ->can('add','App\Models\Categroy');

    Route::post('/categories/add', [CategoryController::class,'store'])
    ->name('store_category')
    ->can('add','App\Models\Categroy');

    Route::get('/categories/{category_id}/edit', [CategoryController::class,'edit'])
    ->name('edit_category')
    ->can('update',['App\Models\Brand','category_id']);

    Route::post('/categories/{category_id}/edit', [CategoryController::class,'update'])
    ->name('update_category')
    ->can('update',['App\Models\Brand','category_id']);

 
    Route::get('/brands', [BrandController::class,'all'])
    ->name('all_brands')
    ->can('view','App\Models\Brand');

    Route::get('/brands/add', [BrandController::class,'create'])
    ->name('add_brand')
    ->can('add','App\Models\Brand');

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
    ->can('update_user',['App\Models\User','user_id']);

    Route::post('/users/{user_id}/edit', [UsersController::class,'update'])
    ->name('update_user')
    ->can('update_user',['App\Models\User','user_id']);


});