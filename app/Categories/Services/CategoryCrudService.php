<?php

namespace App\Categories\Services;

use App\Categories\Interfaces\CategoryCrudRepositoryInterface;
use App\Categories\Interfaces\CategoryCrudServiceInterface;

class CategoryCrudService implements CategoryCrudServiceInterface{

    protected CategoryCrudRepositoryInterface $category_crud_repository;

    public function __construct(
        CategoryCrudRepositoryInterface $category_crud_repository
    ) {
        $this->category_crud_repository = $category_crud_repository;
    }

    public function CreateCategory($company_id,array $details){
        $details['company_id'] = $company_id;
        $category = $this->category_crud_repository->create_category($details);
        return $category;
    }

    public function UpdateCategory($category_id,array $details){
        return $this->category_crud_repository->update_category($category_id,$details);
    }

    public function GetCompanyCategories($company_id){
        return $this->category_crud_repository->get_categories_by_company_id($company_id);       
    }

    public function GetCategory($id){
        return $this->category_crud_repository->get_category_by_id($id);
    }
    
}