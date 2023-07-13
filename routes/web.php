<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompnayController;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard')->middleware(Authenticate::class);

Route::get('/login', [AuthenticationController::class,'login_form'])->name('login');
Route::post('/login', [AuthenticationController::class,'login']);

Route::get('/companies', [CompnayController::class,'all'])->name('all_companies');
Route::get('/companies/add', [CompnayController::class,'create'])->name('add_company');
Route::post('/companies/add', [CompnayController::class,'store'])->name('store_company');
Route::get('/companies/{company_id}/activate', [CompnayController::class,'activate'])->name('company_activate');
Route::get('/companies/{company_id}/deactivate', [CompnayController::class,'deactivate'])->name('company_deactivate');
Route::get('/companies/{company_id}/edit', [CompnayController::class,'edit'])->name('company_edit');
Route::post('/companies/{company_id}/edit', [CompnayController::class,'update'])->name('company_update');

Route::get('/users', [UsersController::class,'all'])->name('all_users')->middleware(Authenticate::class);
Route::get('/users/add', [UsersController::class,'create'])->name('add_user')->middleware(Authenticate::class);
Route::post('/users/add', [UsersController::class,'store'])->name('store_user')->middleware(Authenticate::class);
Route::get('/users/{user_id}/activate', [UsersController::class,'activate'])->name('user_activate')->middleware(Authenticate::class);
Route::get('/users/{user_id}/deactivate', [UsersController::class,'deactivate'])->name('user_deactivate')->middleware(Authenticate::class);
Route::get('/users/{user_id}/edit', [UsersController::class,'edit'])->name('user_edit')->middleware(Authenticate::class);
Route::post('/users/{user_id}/edit', [UsersController::class,'update'])->name('user_update')->middleware(Authenticate::class);