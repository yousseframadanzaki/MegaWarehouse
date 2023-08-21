<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Categories\Interfaces\CategoryCrudServiceInterface;
use App\Categories\Requests\CreateCategoryRequest;
use App\Categories\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{

    private CategoryCrudServiceInterface $CategoryCrudService;
    private CommonDataServiceInterface $CommonDataService;

    public function __construct(
            CategoryCrudServiceInterface $CategoryCrudService,
            CommonDataServiceInterface $CommonDataService
    ){
        $this->CommonDataService = $CommonDataService;
        $this->CategoryCrudService = $CategoryCrudService;
    }

    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $company_id = $this->company_id();
        $categories = $this->CategoryCrudService->GetCompanyCategories($company_id);
        return view('Dashboard.Categories.show_all')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_id = $this->company_id();
        $categories = $this->CommonDataService->GetCompanyCategories($company_id);
        return view('Dashboard.Categories.add')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $company_id = $this->company_id();
        $category = $this->CategoryCrudService->CreateCategory($company_id,$request->validated());
        if($category){
            return back()->with('success','category_created_success');
        }
        return back()->with('error','category_created_error');
    }

    public function edit($category_id)
    {
        $company_id = $this->company_id();
        $category = $this->CategoryCrudService->GetCategory($category_id);
        $categories = $this->CommonDataService->GetCompanyCategories($company_id);
        return view('Dashboard.Categories.edit')->with(['category'=>$category,'categories'=>$categories]);
    }

    public function update(UpdateCategoryRequest $request,$category_id)
    {
        if(!$this->CategoryCrudService->UpdateCategory($category_id,$request->validated())){
            return back()->with('error','category_updated_error');
        }
        return back()->with('success','category_updated_success');
    }

    public function show($category_id) {
        $data = $this->CategoryCrudService->GetCategoryWithProducts($category_id);
        return view("Dashboard.Categories.show_one")->with('data',$data);
    }

}
