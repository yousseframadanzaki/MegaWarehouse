<?php

namespace App\Products\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
use App\Products\Interfaces\ProductAttributesRepositoryInterface;
use App\Products\Interfaces\ProductVariantsRepositoryInterface;

use App\Products\Interfaces\ProductCrudRepositoryInterface;
use App\Products\Interfaces\ProductCrudServiceInterface;

class ProductCrudService implements ProductCrudServiceInterface{


    public function __construct(
        protected readonly  ProductCrudRepositoryInterface $product_crud_repository,
        protected readonly  ProductAttributesRepositoryInterface $product_attributes_repository,
        protected readonly  ProductVariantsRepositoryInterface $product_variants_repository,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
    ) {}

    public function AddProduct($company_id,array $details){
        $details['product_info']['company_id'] = $company_id;
        $product = $this->product_crud_repository->add_product($details['product_info']);
        
        if(isset($details['product_attributes']) && count($details['product_attributes']) > 0 ){
            $attributes = $this->product_attributes_repository->add_attributes($product->id,$details['product_attributes']);
            $variants = $this->product_variants_repository->add_variants($product,$attributes,$details['product_variants']);
        }else{
            $variants = $this->product_variants_repository->add_default_variant($product);
        }


        $this->add_images($product->id,$details);

        

        return $product;
    }

    private function files_equal($file1,$file2) {
        if(
            $file1->getClientOriginalName() === $file2->getClientOriginalName()
            &&
            $file1->getSize() === $file2->getSize()
        ){
            return true;
        }
        return false;
    }

    public function GetCompanyProducts($company_id){
        return $this->product_crud_repository->get_products_by_company_id($company_id);
    }

    public function GetProduct($product_id) {
        return $this->product_crud_repository->get_product_by_id($product_id);
    }

    public function UpdateProduct($product_id,array $details) {
        $product = $this->product_crud_repository->update_product_by_id($product_id,$details['product_info']);

        $this->update_images($product_id,$details);

        return $product;
    }

    private function add_images($product_id,$data) {     
        

        if(count($data["product_images"]) == 1 && $data["product_images"][0]->getClientOriginalName() == "blob"){
            return;
        }

        if(isset($data['main_image'])){
            $main_image = $this->FileUploadService->product_main($data["main_image"],$product_id);
            $this->MediaService->save($main_image);
        }else{
            $main_image = $this->FileUploadService->product_main($data["product_images"][0],$product_id);
            $this->MediaService->save($main_image);
        }

        foreach ($data["product_images"] as $image) {
            if(!$this->files_equal($image,$data["main_image"])){
                $file = $this->FileUploadService->product($image,$product_id);
                $this->MediaService->save($file);
            }
        }
    }

    private function update_images($product_id,$data) {     
        

        if(count($data["product_images"]) == 1 && $data["product_images"][0]->getClientOriginalName() == "blob"){
            return;
        }

        if(isset($data['main_image'])){
            $old_main = $this->MediaService->GetMediaByCollection("product.main_image",$product_id);
            if($old_main){
                $this->MediaService->UpdateMediaCollection($old_main->id,"product");
            }
            $main_image = $this->FileUploadService->product_main($data["main_image"],$product_id);
            $this->MediaService->save($main_image);
        }else{
            $main_image = $this->FileUploadService->product_main($data["product_images"][0],$product_id);
            $this->MediaService->save($main_image);
            unset($data["product_images"][0]);
        }

        foreach ($data["product_images"] as $image) {
            if(!isset($data["main_image"]) || !$this->files_equal($image,$data["main_image"])){
                $file = $this->FileUploadService->product($image,$product_id);
                $this->MediaService->save($file);
            }
        }
    }




}