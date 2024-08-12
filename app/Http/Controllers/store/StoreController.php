<?php

namespace App\Http\Controllers\store;

use App\Products\Interfaces\ProductCrudServiceInterface;
use App\Categories\Interfaces\CategoryCrudServiceInterface;
use App\CommonData\Interfaces\CommonDataServiceInterface;

use App\Products\Filters\ProductFilters;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private ProductCrudServiceInterface $ProductCrudService;
    private CategoryCrudServiceInterface $CategoryCrudService;
    private CommonDataServiceInterface $CommonDataService;

    public function __construct(
        ProductCrudServiceInterface $ProductCrudService,
        CategoryCrudServiceInterface $CategoryCrudService,
        CommonDataServiceInterface $CommonDataService,
    ) {
        $this->ProductCrudService = $ProductCrudService;
        $this->CategoryCrudService = $CategoryCrudService;
        $this->CommonDataService = $CommonDataService;
    }
    public function index(Request $request, ProductFilters $filters) {
        $categories = $this->CategoryCrudService->GetCompanyCategories(5);
        return view('store.homepage', compact('categories'));
    }

    public function show_category($category_id) {
        $categories = $this->CategoryCrudService->GetCompanyCategories(5);
        $category = $this->CategoryCrudService->GetCategoryWithProducts($category_id)->load(['products.variants' => function ($query) {
            $query->where('quantity', '>', 0);
        }]);
        return view('store.show_category', compact('categories', 'category'));
    }

    public function create_order() {
        $countries = $this->CommonDataService->GetCountries();
        return view('store.add_order', compact('countries'));
    }
}
