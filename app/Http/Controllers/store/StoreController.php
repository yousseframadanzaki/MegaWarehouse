<?php

namespace App\Http\Controllers\store;

use App\Products\Interfaces\ProductCrudServiceInterface;
use App\Categories\Interfaces\CategoryCrudServiceInterface;
use App\Products\Filters\ProductFilters;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private ProductCrudServiceInterface $ProductCrudService;
    private CategoryCrudServiceInterface $CategoryCrudService;

    public function __construct(
        ProductCrudServiceInterface $ProductCrudService,
        CategoryCrudServiceInterface $CategoryCrudService
    ) {
        $this->ProductCrudService = $ProductCrudService;
        $this->CategoryCrudService = $CategoryCrudService;
    }
    public function index(Request $request, ProductFilters $filters) {
        $categories = $this->CategoryCrudService->GetCompanyCategories(5);
        // dd($products);
        return view('store.homepage', compact('categories'));
    }

    public function show_category($category_id) {
        $categories = $this->CategoryCrudService->GetCompanyCategories(5);
        $category = $this->CategoryCrudService->GetCategoryWithProducts($category_id);
        return view('store.show_category', compact('categories', 'category'));
    }
}
