<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompnayController;
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


Route::get('/companies/add', [CompnayController::class,'create'])->name('add_company');
Route::post('/companies/add', [CompnayController::class,'store'])->name('store_company');