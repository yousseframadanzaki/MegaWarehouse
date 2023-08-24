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

        $this->add_images($product,$details);

        return $product;
    }

    public function GetCompanyProducts($company_id,$filters){
        return $this->product_crud_repository->get_products_by_company_id($company_id,$filters);
    }

    public function GetProduct($product_id) {
        return $this->product_crud_repository->get_product_by_id($product_id);
    }

    public function UpdateProduct($product_id,array $details) {
        $product = $this->product_crud_repository->update_product_by_id($product_id,$details['product_info']);
        $product = $this->product_crud_repository->get_product_by_id($product_id);
        if(isset($details['product_images']) && !empty($details['product_images'])){
            $this->add_images($product,$details['product_images']);
        }
        return $product;
    }

    private function add_images($product,$images) {
        foreach ($images as $image) {
            $file = $this->FileUploadService->product($image,$product->company_id,$product->id);
            $this->MediaService->save($file);
        }
        // if(isset($data["product_images"]) && count($data['product_images']) > 0){
        //     // $main_image = $this->FileUploadService->product_main($data["product_images"][0],$company_id,$product_id);
        //     // $this->MediaService->save($main_image);
        //     // unset($data["product_images"][0]);
        //     foreach ($data["product_images"] as $image) {
        //         $file = $this->FileUploadService->product($image,$company_id,$product_id);
        //         $this->MediaService->save($file);
        //     }
        // }
    }

    public function GetVariantPrint($variant_id) {
        return $this->product_variants_repository->get_variant_by_id($variant_id);
    }
}