<?php

namespace App\Stock\Services;

use App\Stock\Interfaces\StockOperationRepositoryInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Products\Interfaces\VariantStockServiceInterface;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

class StockOperationService implements StockOperationServiceInterface{


    public function __construct(
        protected readonly StockOperationRepositoryInterface $stock_operation_repository,
        protected readonly VariantStockServiceInterface $VariantStockService,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
    ){}

    public function CreateOperation($user,array $details){
        return $this->{$details['type']}($user,$details);
    }

    public function GetCompanyStock($company_id,$filters) {
        return $this->stock_operation_repository->get_operations_by_company_id($company_id,$filters);
    }
    
    function move($user,$details) {

        $details['admin_id'] = $user->id;

        if(isset($details['image'])){
            $image = $details['image'];
            unset($details['image']);
        }

        $remove_details = $details;
        $add_details = $details;

        $remove_details['quantity'] = $remove_details['quantity']*-1;
        unset($remove_details['warehouse_to']);
        $remove_id = $this->stock_operation_repository->create($remove_details);

        $add_details['warehouse'] = $add_details['warehouse_to'];
        unset($add_details['warehouse_to']);
        $add_id = $this->stock_operation_repository->create();

        if($image){
            $file = $this->FileUploadService->stock($image,$user->company_id,$remove_id);
            $this->MediaService->save($file);
    
            $file->collection_id = $add_id;
            $this->MediaService->save($file);
        }

        return $add_id;

    }

    function buy($user,$details) {
        $operation['warehouse_id'] = $details['warehouse_id'];
        $operation['note'] = $details['note'];
        $operation['type'] = $details['type'];
        $operation['admin_id'] = $user->id;
        $operation['company_id'] = $user->company_id;

        $ids = array();

        foreach ($details['product_variants'] as $variant) {
            if($variant['quantity']){
                $operation['variant_id'] = $variant['id'];
                $operation['quantity'] = $variant['quantity'];
                $ids[]   = $this->stock_operation_repository->create($operation);
                $this->VariantStockService->UpdateStock($variant['id'],$variant['quantity']);
            }
        }

        if(isset($details['image']) && count($ids) > 0){
            $file = $this->FileUploadService->stock($details['image'],$user->company_id);
            foreach ($ids as $id) {
                $file->collection_id = $id;
                $this->MediaService->save($file);
            }
        }
        
        return $ids;
    }

    function sell($details) {

    }

    function returned_orders($details) { 

    }

    function returned_suppliers($details) {

    }

}