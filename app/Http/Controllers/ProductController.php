<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Products\Requests\CreateProductRequest;
use App\Products\Interfaces\ProductCrudServiceInterface;


class ProductController extends Controller
{

    private CommonDataServiceInterface $CommonDataService;
    private ProductCrudServiceInterface $ProductCrudService;

    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        ProductCrudServiceInterface $ProductCrudService
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->ProductCrudService = $ProductCrudService;
    }


    public function all() {
        $company_id = auth()->user()->company_id;
        $products = $this->ProductCrudService->GetCompanyProducts($company_id);
        return view("Dashboard.Products.show_all")->with('products',$products);
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
    
    public function store(CreateProductRequest $request) {
        $data = $request->all();
        // dd($data);
        $company_id = auth()->user()->company_id;

        $product = $this->ProductCrudService->AddProduct($company_id,$data);

        if(!$product){
            $request->session()->flash('erroe', 'error adding product');
            return response()->json();
        }

        $request->session()->flash('success', 'New product added successfully.');
        return response()->json($product);
    }
}
