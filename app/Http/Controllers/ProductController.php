<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Products\Repositories\ProductAttributesRepository;
use App\Products\Repositories\ProductCrudRepository;
use App\Products\Repositories\ProductVariantsRepository;

use App\CommonData\Interfaces\CommonDataServiceInterface;


class ProductController extends Controller
{

    public function __construct(CommonDataServiceInterface $CommonDataService)
    {
        $this->CommonDataService = $CommonDataService;
    }

    public function create() {
        $company_id = auth()->user()->company_id;
        $suppliers  = $this->CommonDataService->GetCompanySuppliers($company_id);
        $categories = $this->CommonDataService->GetCompanyCategories($company_id);
        $brands = $this->CommonDataService->GetCompanyBrands($company_id);
        $data = array(
            'suppliers'=>$suppliers,
            'categories'=>$categories,
            'brands'=>$brands
        );
        return view('Dashboard.Products.add')->with('data',$data);
    }
    
    public function store(Request $request) {
        $data = $request->except('_token');
        $data['product_info']['cost'] = 20;
        $data['product_info']['price'] = 120;
        $data['product_info']['sale_price'] = 100;
        $data['product_info']['brand_id'] = 1;
        $data['product_info']['main_category_id'] = 3;
        $data['product_info']['sub_category_id'] = 4;
        $data['product_info']['company_id'] = auth()->user()->company_id;
        $data['product_info']['supplier_id'] = 1;
        $data['product_info']['description'] = 'description';

        // dd($data);

        $attribute_repo = new ProductAttributesRepository();
        $product_repo = new ProductCrudRepository();
        $variant_repo = new ProductVariantsRepository();

        $product = $product_repo->add_product($data['product_info']);
        $attributes = $attribute_repo->add_attributes($product->id,$data['product_attributes']);
        $variants = $variant_repo->add_variants($product->id,$attributes,$data['product_variants']);
        return redirect()->back();
    }
}
