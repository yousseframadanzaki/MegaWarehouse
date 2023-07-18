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
    Route::get('/companies/{company_id}/activate', [CompnayController::class,'activate'])->name('company_activate');
    Route::get('/companies/{company_id}/deactivate', [CompnayController::class,'deactivate'])->name('company_deactivate');
    Route::get('/companies/{company_id}/edit', [CompnayController::class,'edit'])->name('company_edit');
    Route::post('/companies/{company_id}/edit', [CompnayController::class,'update'])->name('company_update');
    
});

Route::group(['prefix' => 'dashboard','middleware' => ['auth','IsNotAdmin']],function () {

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/brands', [BrandController::class,'all'])->name('all_brands');
    Route::get('/brands/add', [BrandController::class,'create'])->name('add_brand');
    Route::post('/brands/add', [BrandController::class,'store'])->name('store_brand');
    Route::get('/brands/{brand_id}/edit', [BrandController::class,'edit'])->name('brand_edit');
    Route::post('/brands/{brand_id}/edit', [BrandController::class,'update'])->name('brand_update');


    Route::get('/roles', [RolesController::class,'all'])->name('all_roles');
    Route::get('/roles/add', [RolesController::class,'create'])->name('add_role');
    Route::post('/roles/add', [RolesController::class,'store'])->name('store_role');
    Route::get('/roles/{role_id}/edit', [RolesController::class,'edit'])->name('role_edit');
    Route::post('/roles/{role_id}/edit', [RolesController::class,'update'])->name('role_update');

    Route::get('/users', [UsersController::class,'all'])->name('all_users');
    Route::get('/users/add', [UsersController::class,'create'])->name('add_user');
    Route::post('/users/add', [UsersController::class,'store'])->name('store_user');
    Route::get('/users/{user_id}/activate', [UsersController::class,'activate'])->name('user_activate');
    Route::get('/users/{user_id}/deactivate', [UsersController::class,'deactivate'])->name('user_deactivate');
    Route::get('/users/{user_id}/edit', [UsersController::class,'edit'])->name('user_edit');
    Route::post('/users/{user_id}/edit', [UsersController::class,'update'])->name('user_update');

});