<?php

namespace App\Brands\Services;

use App\Brands\Interfaces\BrandCrudRepositoryInterface;
use App\Brands\Interfaces\BrandCrudServiceInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

class BrandCrudService implements BrandCrudServiceInterface{

    protected BrandCrudRepositoryInterface $brand_crud_repository;
    protected UploadServiceInterface $FileUploadService;
    protected MediaCrudServiceInterface $MediaCrudService;

    public function __construct(
        BrandCrudRepositoryInterface $brand_crud_repository,
        UploadServiceInterface $FileUploadService,
        MediaCrudServiceInterface $MediaCrudService
    ) {
        $this->brand_crud_repository = $brand_crud_repository;
        $this->FileUploadService = $FileUploadService;
        $this->MediaCrudService = $MediaCrudService;
    }

    public function CreateBrand($company_id,array $details){
        $details['company_id'] = $company_id;
        if(!isset($details['logo'])){
            $brand = $this->brand_crud_repository->create_brand($details);
            return $brand;
        }
        $logo = $details['logo'];
        unset($details['logo']);
        $brand = $this->brand_crud_repository->create_brand($details);
        $image = $this->FileUploadService->brand($logo,$company_id,$brand->id);
        $this->MediaCrudService->save($image);
        return $brand;
    }

    public function UpdateBrand($brand_id,array $details){
        if(!isset($details['logo'])){
            return $this->brand_crud_repository->update_brand($brand_id,$details);
        }
        $logo = $details['logo'];
        unset($details['logo']);
        $brand = $this->brand_crud_repository->update_brand($brand_id,$details);
        $brand = $this->GetBrand($brand_id);
        $image = $this->FileUploadService->brand($logo,$brand->company_id,$brand_id);
        $this->MediaCrudService->save($image);
        return $brand;
    }

    public function GetCompanyBrands($company_id){
        return $this->brand_crud_repository->get_brands_by_company_id($company_id);       
    }

    public function GetBrand($id){
        return $this->brand_crud_repository->get_brand_by_id($id);
    }
    public function GetBrandWithProducts($id){
        return $this->brand_crud_repository->get_brand_with_products($id);
    }
    
}