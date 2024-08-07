<?php

namespace App\Http\Controllers\store;

use App\Products\Interfaces\ProductCrudServiceInterface;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private ProductCrudServiceInterface $ProductCrudService;

    public function __construct(
        ProductCrudServiceInterface $ProductCrudService
    ) {
        $this->ProductCrudService = $ProductCrudService;
    }
    public function index(Request $request) {
        $page = $request->input('page', 1);
        $variants = $this->ProductCrudService->GetAllVariants($page);
        return view('store.homepage', compact('variants'));
    }
}
