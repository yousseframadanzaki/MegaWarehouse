<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Brands\Interfaces\BrandCrudServiceInterface;
use App\Brands\Requests\CreateBrandRequest;
use App\Brands\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    private BrandCrudServiceInterface $BrandCrudService;

    public function __construct(BrandCrudServiceInterface $BrandCrudService){
        $this->BrandCrudService = $BrandCrudService;
    }

    public function all() {
        $company_id = $this->company_id();
        $brands = $this->BrandCrudService->GetCompanyBrands($company_id);
        return view('Dashboard.Brands.show_all')->with('brands',$brands);
    }

    public function create() {
        return view('Dashboard.Brands.add');
    }

    public function store(CreateBrandRequest $request) {
        $company_id = $this->company_id();
        $brand = $this->BrandCrudService->CreateBrand($company_id,$request->validated());
        if($brand){
            return back()->with('success','brand_created_success');
        }
        return back()->with('error','brand_created_error');
    }

    public function edit($brand_id) {
        $brand = $this->BrandCrudService->GetBrand($brand_id);
        return view('Dashboard.Brands.edit')->with('brand',$brand);
    }

    public function update(UpdateBrandRequest $request,$brand_id){
        if(!$this->BrandCrudService->UpdateBrand($brand_id,$request->validated())){
            return back()->with('error','brand_updated_error');
        }
        return back()->with('success','brand_updated_success');
    }

    public function show($brand_id) {
        $data = $this->BrandCrudService->GetBrandWithProducts($brand_id);
        return view("Dashboard.Brands.show_one")->with('data',$data);
    }

}
