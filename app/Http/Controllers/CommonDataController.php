<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;

class CommonDataController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;

    public function __construct(CommonDataServiceInterface $CommonDataService)
    {
        $this->CommonDataService = $CommonDataService;
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
        return response()->json($this->CommonDataService->GetProductVariants($product_id));
    }
    public function attributes($product_id) {
        return response()->json($this->CommonDataService->GetProductAttributes($product_id));
    }

    public function variant_data($variant_id) {
        return response()->json($this->CommonDataService->GetVariant($variant_id));
    }

}
