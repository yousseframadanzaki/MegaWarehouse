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

        if(isset($details["main_image"])){
           $file = $this->FileUploadService->product_main($details["main_image"],$product->id);
           $this->MediaService->save($file);
        }
        
        if(isset($details["product_images"])){
            if(isset($details["main_image"])){
                foreach ($details["product_images"] as $image) {       
                    if(!$this->compare_files($image,$details["main_image"])){
                        $file = $this->FileUploadService->product($image,$product->id);
                        $this->MediaService->save($file);
                    }         
                }
            }else{
                foreach ($details["product_images"] as $image) {       
                    $file = $this->FileUploadService->product($image,$product->id);
                    $this->MediaService->save($file);     
                }
            }
        }

        return $product;
    }

    private function compare_files($file1,$file2) {
        if(
            $file1->getClientOriginalName() === $file2->getClientOriginalName()
            &&
            $file1->getSize() === $file2->getSize()
        ){
            return true;
        }
        return false;
    }

}