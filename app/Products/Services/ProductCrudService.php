<?php

namespace App\Products\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

use App\Products\Interfaces\ProductAttributesRepositoryInterface;
use App\Products\Interfaces\ProductVariantsRepositoryInterface;
use App\Products\Interfaces\ProductPackageRepositoryInterface;

use App\Products\Interfaces\ProductCrudRepositoryInterface;
use App\Products\Interfaces\ProductCrudServiceInterface;

class ProductCrudService implements ProductCrudServiceInterface
{


    public function __construct(
        protected readonly  ProductCrudRepositoryInterface $product_crud_repository,
        protected readonly  ProductAttributesRepositoryInterface $product_attributes_repository,
        protected readonly  ProductVariantsRepositoryInterface $product_variants_repository,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
        protected readonly  ProductPackageRepositoryInterface $product_package_repository,
    ) {
    }

    public function AddProduct($company_id, array $details)
    {
        $details['product_info']['company_id'] = $company_id;
        if (!empty($details['product_info']['is_store'])) {
            if ($details['product_info']['is_store'] == 'on') {
                $details['product_info']['is_store'] = '1';
            }
        } else {
            $details['product_info']['is_store'] = '0';
        }
        if (!empty($details['product_info']['show_quantity'])) {
            if ($details['product_info']['show_quantity'] == 'on') {
                $details['product_info']['show_quantity'] = '1';
            }
        } else {
            $details['product_info']['show_quantity'] = '0';
        }
        if (!empty($details['product_info']['confirm_order'])) {
            if ($details['product_info']['confirm_order'] == 'on') {
                $details['product_info']['confirm_order'] = '1';
            }
        } else {
            $details['product_info']['confirm_order'] = '0';
        }
        $product = $this->product_crud_repository->add_product($details['product_info']);
        if (isset($details['product_attributes']) && count($details['product_attributes']) > 0) {
            $attributes = $this->product_attributes_repository->add_attributes($product->id, $details['product_attributes']);
            $variants = $this->product_variants_repository->add_variants($product, $attributes, $details['product_variants']);
        } else {
            $variants = $this->product_variants_repository->add_default_variant($product);
        }
        if (!empty($details['images'])) {
            $this->add_images($product, $details['images']);
        }

        return $product;
    }

    public function GetCompanyProducts($company_id, $filters)
    {
        return $this->product_crud_repository->get_products_by_company_id($company_id, $filters);
    }

    public function GetProduct($product_id)
    {
        return $this->product_crud_repository->get_product_by_id($product_id);
    }

    public function UpdateProduct($product_id, array $details)
    {
        $product = $this->product_crud_repository->update_product_by_id($product_id, $details['product_info']);
        $product = $this->product_crud_repository->get_product_by_id($product_id);
        if (isset($details['images']) && !empty($details['images'])) {
            $this->add_images($product, $details['images']);
        }
        if (isset($details['product_attributes']) && count($details['product_attributes']) > 0) {
            $attributes = $this->product_attributes_repository->add_attributes($product->id, $details['product_attributes']);
            $variants = $this->product_variants_repository->add_variants($product, $attributes, $details['product_variants']);
        } else if ($product->variants->count() == 0) {
            $variants = $this->product_variants_repository->add_default_variant($product);
        }
        return $product;
    }

    public function UpdateVariant($variant_id, $data)
    {
        return $this->product_variants_repository->update_variant_by_id($variant_id, $data);
    }

    private function add_images($product, $images)
    {
        foreach ($images as $image) {
            $file = $this->FileUploadService->handle($image, 'product', $product->company_id, $product->id);
            $this->MediaService->save($file);
        }
    }

    public function GetVariantPrint($variant_id)
    {
        return $this->product_variants_repository->get_variant_by_id($variant_id);
    }

    public function GetBulkVariantsData($variants_ids)
    {
        return $this->product_variants_repository->get_variants($variants_ids);
    }

    public function AddPackage($company_id,array $details) {
        // dd($details);
        $details['product_info']['company_id'] = $company_id;
        if (!empty($details['product_info']['show_quantity'])) {
            if ($details['product_info']['show_quantity'] == 'on') {
                $details['product_info']['show_quantity'] = '1';
            }
        } else {
            $details['product_info']['show_quantity'] = '0';
        }
        if (!empty($details['product_info']['confirm_order'])) {
            if ($details['product_info']['confirm_order'] == 'on') {
                $details['product_info']['confirm_order'] = '1';
            }
        } else {
            $details['product_info']['confirm_order'] = '0';
        }

        $details['product_info']['is_bundle'] = '1';
        $package = $this->product_crud_repository->add_product($details['product_info']);

        if (!empty($details['package'])) {
            $this->product_package_repository->AddPackageItems($package->id, $details['package']);
        }
        if (!empty($details['images'])) {
            $this->add_images($package, $details['images']);
        }

        return $package;
    }

    public function GetAllVariants($page) {
        return $this->product_variants_repository->get_all_variants($page);
    }

    public function DeleteProduct($product_id) {
        return $this->product_crud_repository->delete_product($product_id);
    }

    public function DeleteVariant($variant_id, $is_bundle) {
        return $this->product_variants_repository->delete_variant($variant_id, $is_bundle);
    }

    public function GetVariantShelfData(array $data) {
        return $this->product_variants_repository->get_variant_shelf_data($data);
    }

    public function IncompleteOrdersVariants($company_id) {
        return $this->product_variants_repository->incomplete_orders_variants($company_id);
    }

    public function GetVariantsByOrders(array $order_ids) {
        return $this->product_variants_repository->get_variants_by_orders($order_ids);
    }
}
