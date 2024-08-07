<?php

namespace App\Http\Controllers\store;

use App\Products\Interfaces\ProductCrudServiceInterface;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Products\Filters\ProductFilters;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private ProductCrudServiceInterface $ProductCrudService;

    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        ProductCrudServiceInterface $ProductCrudService
    ) {
        $this->CommonDataService = $CommonDataService;
        $this->ProductCrudService = $ProductCrudService;
    }
    public function index(Request $request) {
        $page = $request->input('page', 1);
        $variants = $this->ProductCrudService->GetAllVariants($page);
        return view('store.homepage', compact('variants'));
    }

    public function get_all_variants(Request $request) {
        // Get the current page number from the request, default to 1 if not provided
        $page = $request->input('page', 1);
        $variants = $this->ProductCrudService->GetAllVariants($page);
        return response()->json([
            'variants' => $variants->items(), // Get the current page items
            'nextPage' => $variants->hasMorePages() ? $page + 1 : null, // Determine if there is a next page
        ]);
    }
}
