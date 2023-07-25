<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('country/{country_id}/cities', [CommonDataController::class ,'city'])->name('country_cities');
Route::get('city/{city_id}/areas', [CommonDataController::class ,'area'])->name('city_area');
Route::get('categories/{category_id}/sub_categories', [CommonDataController::class ,'sub_categories'])->name('category_sub_categories');
