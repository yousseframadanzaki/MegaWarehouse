<?php

use App\Http\Controllers\AccountingController;
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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\OrderNotesController;
use App\Http\Controllers\admin\CompnayController;
use App\Http\Controllers\ShippingCompanyController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\store\StoreController;
use App\Models\Order;
use App\Models\Product;

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

Route::name('api_')->group(function() {
    Route::get('country/{country_id}/cities', [CommonDataController::class, 'city'])->name('country_cities');
    Route::get('city/{city_id}/areas', [CommonDataController::class, 'area'])->name('city_areas');
    Route::get('product/{product_id}/variants', [CommonDataController::class, 'variants'])->name('product_variants');
    Route::get('product/{product_id}/attributes', [CommonDataController::class, 'attributes'])->name('product_attributes');
    Route::get('variants/{variant_id}/stock', [StockController::class, 'variants_stock'])->name('variants_stock');
    Route::get('variants/{variant_id}', [CommonDataController::class, 'variant_data'])->name('variants_data');
    Route::get('clients/{client_phone}', [ClientController::class, 'get_client_by_phone'])->name('client_search');
    Route::get('categories/{category_id}/sub_categories', [CommonDataController::class, 'sub_categories'])->name('category_sub_categories');
    Route::delete('media/{id}', [MediaController::class, 'destroy'])->name('delete_media');
    Route::get('status/{status_id}/images', [MediaController::class, 'status_images'])->name('status_media');


    Route::post('/cart/add', [CartController::class, 'store'])->name('store_cart');
    Route::post('/cart/update', [CartController::class, 'update'])->name('update_cart');
    Route::post('/cart/{variant_id}/delete', [CartController::class, 'destroy'])->name('delete_cart');

    // mega apis
    Route::post('/shipping_status/map', [ShippingStatusController::class, 'map'])->name('map_status');
    Route::post('/status_callback/{mega_company_code}', [OrderController::class, 'status_callback'])->name('status_callback');
    Route::post('/status_callback_delete/{mega_company_code}', [OrderController::class, 'status_callback_delete'])->name('status_callback_delete');
    Route::post('/cost_callback/{mega_company_code}', [OrderController::class, 'mega_cost'])->name('mega_cost');
    Route::post('/payment_callback/{mega_company_code}', [OrderController::class, 'mega_payment'])->name('mega_payment');
    Route::post('/shipping_area/map', [ShippingAreaController::class, 'map'])->name('map_area');
    // end apis

    Route::get('/company/{company_id}/users', [CompnayController::class, 'get_company_users'])->name('company_users');
    Route::get('/stock/scan', [StockController::class, 'scan'])->name('scan_stock');
    Route::post('/stock/{id}/remove', [StockController::class, 'remove_stock'])->name('remove_stock');
    Route::post('/stock/update_varient_shelf', [StockController::class, 'update_variant_shelf'])->name('update_variant_shelf');
    Route::get('/order/scan_items', [OrderController::class, 'scan_items'])->name('scan_items');
    Route::post('/sectors/{id}/edit', [AreaController::class, 'edit_area'])->name('edit_area');
    Route::post('/sectors/{id}/edit_city', [AreaController::class, 'edit_city'])->name('edit_city');
    Route::post('/sectors/{id}/edit_shipping_company', [AreaController::class, 'edit_shipping_company'])->name('edit_shipping_company');
    Route::post('/sectors/{id}/edit_keywords', [AreaController::class, 'edit_keywords'])->name('edit_keywords');
    Route::get('/order/{order_id}/notes', [OrderNotesController::class, 'notes'])->name('notes');
    Route::POST('/order/{id}/add_note', [OrderNotesController::class, 'create_note'])->name('create_note');
    Route::POST('/orders/search', [OrderController::class, 'search_orders'])->name('search_orders');
    Route::GET('/area/{id}/get_price', [AreaController::class, 'get_price'])->name('get_price');
    Route::get('/area/{id}/get_keywords', [AreaController::class, 'get_keywords'])->name('get_keywords');
    Route::get('client/{id}/get_templates', [ClientController::class, 'get_templates'])->name('get_templates');
    Route::post('statuses/{id}/settings', [StatusController::class, 'update_status'])->name('update_edit_order');
    Route::post('statuses/{id}/related_shipping', [StatusController::class, 'update_related_shipping'])->name('update_related_shipping');
    Route::post('statuses/{id}/show_all_orders', [StatusController::class, 'update_show_all_orders']);
    Route::POST('statuses/{id}/add_status', [StatusController::class, 'add_related_status'])->name('add_status');
    Route::POST('statuses/related_status/{related_status}/remove', [StatusController::class, 'remove_related_status'])->name('remove_status');
    Route::POST('statuses/{id}/color', [StatusController::class, 'update_status_color']);
    Route::get('payment_category/{payment_category}/data', [AccountingController::class, 'get_payment_category_data']);
    Route::get('payment_type/{id}/userdata', [AccountingController::class, 'get_payment_type_userdata']);
    Route::get('campaign/get_qr_code/{instance_id}',[WhatsappController::class, 'get_qr_code']);
    Route::post('campaign/{device_id}/delete_device',[WhatsappController::class, 'delete_device']);
    Route::POST('campaign/{campaign_id}/edit_status', [WhatsappController::class, 'edit_status']);
    Route::get('shipping_company/orders', [ShippingCompanyController::class, 'get_orders_by_status_id']);

    Route::post('order/{id}/delete', [OrderController::class, 'destroy']);
    Route::post('product/{id}/delete', [ProductController::class, 'destroy']);
    Route::post('variant/{id}/delete', [ProductController::class, 'destroy_variant']);
    Route::get('variant/shelf-data', [ProductController::class, 'get_variant_shelf_data']);
    Route::get('supplier/{supplier_id}/products', [CommonDataController::class, 'get_supplier_products']);


    Route::get('get_all_variants', [ProductController::class, 'get_all_variants']);
    Route::get('get_bulk_variants_data', [ProductController::class, 'get_bulk_variants_data']);

    Route::post('shipping_report/orders/validate', [OrderController::class, 'validate_shipping_report_orders']);
});
