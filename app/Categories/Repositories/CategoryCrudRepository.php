<?php

namespace App\Categories\Repositories;

use App\Models\Category;
use App\Categories\Interfaces\CategoryCrudRepositoryInterface;
use App\Helpers\PaginationHelper;
class CategoryCrudRepository implements CategoryCrudRepositoryInterface{

    public function create_category(array $details){
        return Category::create($details);
    }

    public function update_category($brand_id,array $details){
        return Category::where(['id'=>$brand_id])->update($details);
    }

    public function get_categories_by_company_id($company_id){
        return Category::with('parent')->where('company_id',$company_id)->paginate(10);
    }

    public function get_category_by_id($id){
        return Category::with('parent')->where('id', $id)->get()->first();
    }

    public function get_category_with_products($id){
        $category = Category::with(['children'])->where('id', $id)->get()->first();
        $products = $category->products;
        foreach ($category->children as $child) {
            $products =  $products->merge($child->products);
        }
        $data['category'] = $category;
        $data['products'] = PaginationHelper::paginate($products,10);
        return $data;
    }

}