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



    Route::get('/suppliers', [SupplierController::class,'all'])->name('all_suppliers');
    Route::get('/suppliers/add', [SupplierController::class,'create'])->name('add_supplier');
    Route::post('/suppliers/add', [SupplierController::class,'store'])->name('store_supplier');
    Route::get('/suppliers/{supplier_id}/edit', [SupplierController::class,'edit'])->name('edit_supplier');
    Route::post('/suppliers/{supplier_id}/edit', [SupplierController::class,'update'])->name('update_supplier');

    Route::get('/client_groups', [ClientGroupController::class,'all'])->name('all_client_groups');
    Route::get('/client_groups/add', [ClientGroupController::class,'create'])->name('add_client_group');
    Route::post('/client_groups/add', [ClientGroupController::class,'store'])->name('store_client_group');
    Route::get('/client_groups/{client_group_id}/edit', [ClientGroupController::class,'edit'])->name('edit_client_group');
    Route::post('/client_groups/{client_group_id}/edit', [ClientGroupController::class,'update'])->name('update_client_group');

    Route::get('/clients', [ClientController::class,'all'])->name('all_clients');
    Route::get('/clients/add', [ClientController::class,'create'])->name('add_client');
    Route::post('/clients/add', [ClientController::class,'store'])->name('store_client');
    Route::get('/clients/{client_id}/edit', [ClientController::class,'edit'])->name('edit_client');
    Route::post('/clients/{client_id}/edit', [ClientController::class,'update'])->name('update_client');

    Route::get('/categories', [CategoryController::class,'all'])->name('all_categories');
    Route::get('/categories/add', [CategoryController::class,'create'])->name('add_category');
    Route::post('/categories/add', [CategoryController::class,'store'])->name('store_category');
    Route::get('/categories/{category_id}/edit', [CategoryController::class,'edit'])->name('edit_category');
    Route::post('/categories/{category_id}/edit', [CategoryController::class,'update'])->name('update_category');

    Route::get('/brands', [BrandController::class,'all'])->name('all_brands');
    Route::get('/brands/add', [BrandController::class,'create'])->name('add_brand');
    Route::post('/brands/add', [BrandController::class,'store'])->name('store_brand');
    Route::get('/brands/{brand_id}/edit', [BrandController::class,'edit'])->name('edit_brand');
    Route::post('/brands/{brand_id}/edit', [BrandController::class,'update'])->name('update_brand');


    Route::get('/roles', [RolesController::class,'all'])->name('all_roles');
    Route::get('/roles/add', [RolesController::class,'create'])->name('add_role');
    Route::post('/roles/add', [RolesController::class,'store'])->name('store_role');
    Route::get('/roles/{role_id}/edit', [RolesController::class,'edit'])->name('edit_role');
    Route::post('/roles/{role_id}/edit', [RolesController::class,'update'])->name('update_role');

    Route::get('/users', [UsersController::class,'all'])->name('all_users');
    Route::get('/users/add', [UsersController::class,'create'])->name('add_user');
    Route::post('/users/add', [UsersController::class,'store'])->name('store_user');
    Route::get('/users/{user_id}/activate', [UsersController::class,'activate'])->name('activate_user');
    Route::get('/users/{user_id}/deactivate', [UsersController::class,'deactivate'])->name('deactivate_user');
    Route::get('/users/{user_id}/edit', [UsersController::class,'edit'])->name('edit_user');
    Route::post('/users/{user_id}/edit', [UsersController::class,'update'])->name('update_user');

});