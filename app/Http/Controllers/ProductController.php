<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Products\Requests\CreateProductRequest;
use App\Products\Interfaces\ProductCrudServiceInterface;
use App\Products\Filters\ProductFilters;


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

    public function show($product_id) {
        $product = $this->ProductCrudService->GetProduct($product_id);
        return view("Dashboard.Products.show_one")->with('product',$product);
    }

    public function all(ProductFilters $filters) {
        $company_id = auth()->user()->company_id;
        $products = $this->ProductCrudService->GetCompanyProducts($company_id,$filters);

        $suppliers  = $this->CommonDataService->GetCompanySuppliers($company_id);
        $categories = $this->CommonDataService->GetCompanyCategories($company_id);
        $brands = $this->CommonDataService->GetCompanyBrands($company_id);
        $data = array(
            'suppliers'=>$suppliers,
            'categories'=>$categories,
            'brands'=>$brands
        );

        return view("Dashboard.Products.show_all")->with(['products'=>$products,'data'=>$data]);
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

    public function edit($product_id) {
        $product = $this->ProductCrudService->GetProduct($product_id);
        $company_id = auth()->user()->company_id;
        $suppliers  = $this->CommonDataService->GetCompanySuppliers($company_id);
        $categories = $this->CommonDataService->GetCompanyCategories($company_id);
        $brands = $this->CommonDataService->GetCompanyBrands($company_id);
        $data = array(
            'suppliers'=>$suppliers,
            'categories'=>$categories,
            'brands'=>$brands,
            'product'=>$product
        );
        return view("Dashboard.Products.edit")->with('data',$data);
    }
    public function update(CreateProductRequest $request,$product_id){
        $data = $request->all();
        $product = $this->ProductCrudService->UpdateProduct($product_id,$data);
        if(!$product){
            $request->session()->flash('erroe', 'error adding product');
            return response()->json();
        }

        $request->session()->flash('success', 'New product added successfully.');
        return response()->json($product);
    }

    public function print($variant_id) {
        $variant = $this->ProductCrudService->GetVariantPrint($variant_id);
        return view('Dashboard.Products.print')->with('variant',$variant);
    }

}
