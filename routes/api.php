<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingStatusController;
use App\Http\Controllers\ShippingAreaController;

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
Route::get('city/{city_id}/areas', [CommonDataController::class ,'area'])->name('city_areas');
Route::get('product/{product_id}/variants', [CommonDataController::class ,'variants'])->name('product_variants');
Route::get('product/{product_id}/attributes', [CommonDataController::class ,'attributes'])->name('product_attributes');
Route::get('variants/{variant_id}/stock', [StockController::class ,'variants_stock'])->name('variants_stock');
Route::get('variants/{variant_id}', [CommonDataController::class ,'variant_data'])->name('variants_data');
Route::get('clients/{client_phone}', [ClientController::class ,'get_client_by_phone'])->name('client_search');
Route::get('categories/{category_id}/sub_categories', [CommonDataController::class ,'sub_categories'])->name('category_sub_categories');
Route::delete('media/{id}', [MediaController::class,'destroy'])->name('delete_media');
Route::get('status/{status_id}/images', [MediaController::class,'status_images'])->name('status_media');


Route::post('/cart/add',[CartController::class,'store'])->name('store_cart');
Route::post('/cart/update',[CartController::class,'update'])->name('update_cart');
Route::post('/cart/{variant_id}/delete',[CartController::class,'destroy'])->name('delete_cart');

Route::post('/shipping_status/map', [ShippingStatusController::class,'map'])->name('map_status');

Route::post('/shipping_area/map', [ShippingAreaController::class,'map'])->name('map_area');