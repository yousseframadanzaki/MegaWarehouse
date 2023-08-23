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
        foreach ($details['product_variants'] as $variant) {
            $current_stock = $this->stock_operation_repository->get_variant_stock_in_warehouse($variant['id'],$details['warehouse_id']);
            if($current_stock < $variant['quantity']){
                return false;
            }
        }

        $ids = array();

        //remove stock from warehouse_id

        $remove_operation['warehouse_id'] = $details['warehouse_id'];
        $remove_operation['note'] = $details['note'];
        $remove_operation['type'] = $details['type'];
        $remove_operation['admin_id'] = $user->id;
        $remove_operation['company_id'] = $user->company_id;

        foreach ($details['product_variants'] as $variant) {
            if($variant['quantity']){
                $remove_operation['variant_id'] = $variant['id'];
                $remove_operation['quantity'] = $variant['quantity'] * -1;
                $ids[] = $this->stock_operation_repository->create($remove_operation);
            }
        }


        //add stock to warehouse_to_id

        $add_operation['warehouse_id'] = $details['warehouse_to_id'];
        $add_operation['note'] = $details['note'];
        $add_operation['type'] = $details['type'];
        $add_operation['admin_id'] = $user->id;
        $add_operation['company_id'] = $user->company_id;

        foreach ($details['product_variants'] as $variant) {
            if($variant['quantity']){
                $add_operation['variant_id'] = $variant['id'];
                $add_operation['quantity'] = $variant['quantity'];
                $ids[] = $this->stock_operation_repository->create($add_operation);
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

    function sell($user,$details) {
        // dd($details);
        $operation['admin_id'] = $user->id;
        $operation['company_id'] = $user->company_id;
        $operation['type'] = $details['type'];
        $operation['order_id'] = $details['order_id'];
        $ids = [];
        foreach ($details['items'] as $id => $item) {
            $operation['variant_id'] = $id;
            $operation['warehouse_id'] = $item['warehouse_id'];
            $operation['quantity'] = $item['quantity'] * -1;
            $ids[]   = $this->stock_operation_repository->create($operation);
            $this->VariantStockService->UpdateStock($id,$operation['quantity']);
        }
        return $ids;
    }

    function returned_orders($details) { 

    }

    function returned_suppliers($details) {

    }

    function DeleteOperations($operation_ids) {
        foreach ($operation_ids as $id) {
            $operation = $this->stock_operation_repository->get_operation_by_id($id);
            $this->VariantStockService->UpdateStock($operation['variant_id'],$operation['quantity']*-1);
            $this->stock_operation_repository->delete_operation_by_id($id);
        }
    }

    function GetVarintsStock($variant_id) {
        return $this->stock_operation_repository->get_variant_stock_warehouse($variant_id);
    }

    public function CheckItemsAvailable($items) {
        foreach ($items as $variant_id => $item) {
            $stock = (int)$this->stock_operation_repository->get_variant_stock_by_warehouse_id($variant_id,$item['warehouse_id']);
            if($stock < (int)$item['quantity']){
                return false;
            }
        }
        return true;
    }

}