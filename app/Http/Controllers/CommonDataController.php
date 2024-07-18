<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Products\Interfaces\ProductCrudServiceInterface;

class CommonDataController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private ProductCrudServiceInterface $ProductCrudService;

    public function __construct(CommonDataServiceInterface $CommonDataService, ProductCrudServiceInterface $ProductCrudService)
    {
        $this->CommonDataService = $CommonDataService;
        $this->ProductCrudService = $ProductCrudService;
    }
    public function city($country_id) {
        return response()->json($this->CommonDataService->GetCities($country_id));
    }

    public function area($city_id) {
        return response()->json($this->CommonDataService->GetAreas($city_id));
    }

    public function sub_categories($category_id) {
        return response()->json($this->CommonDataService->GetSubCategories($category_id));
    }

    public function variants($product_id) {
        $product = $this->ProductCrudService->GetProduct($product_id);
        if ($product->is_bundle == 1)
            return response()->json($this->CommonDataService->GetProductVariants($product_id, 1));

        return response()->json($this->CommonDataService->GetProductVariants($product_id));
    }

    public function attributes($product_id) {
        return response()->json($this->CommonDataService->GetProductAttributes($product_id));
    }

    public function variant_data($variant_id) {
        return response()->json($this->CommonDataService->GetVariant($variant_id));
    }

    public function get_supplier_products($supplier_id) {
        return $this->CommonDataService->GetSupplierProducts($this->company_id(), $supplier_id);
    }
}
