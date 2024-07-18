<?php

namespace App\Stock\Services;

use App\Stock\Interfaces\StockOperationRepositoryInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Products\Interfaces\VariantStockServiceInterface;
use App\Invoices\Interfaces\InvoiceServiceInterface;
use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
class StockOperationService implements StockOperationServiceInterface{


    public function __construct(
        protected readonly StockOperationRepositoryInterface $stock_operation_repository,
        protected readonly VariantStockServiceInterface $VariantStockService,
        protected readonly InvoiceServiceInterface $InvoiceService,
        protected readonly OrdersRepositoryInterface $OrdersRepository,
        protected readonly UploadServiceInterface $FileUploadService,
        protected readonly MediaCrudServiceInterface $MediaService,
    ){}

    public function CreateOperation($user,array $details){
        return $this->{$details['type']}($user,$details);
    }

    public function GetCompanyStock($company_id,$filters) {
        return $this->stock_operation_repository->get_operations_by_company_id($company_id,$filters);
    }

    function move($user,$details) {
        foreach ($details['product_variants'] as $variant) {
            if (empty($variant['quantity']))
                continue;

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
            $file = $this->FileUploadService->handle($details['image'],'stock',$user->company_id);
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

        $variants = $this->GetVariantsUnitValues($details['product_variants']);

        foreach ($variants as $variant) {
            if($variant['quantity']){
                $operation['variant_id'] = $variant['id'];
                $operation['quantity'] = $variant['quantity'];
                $operation['unit_price'] = $variant['unit_price'];
                $operation['unit_cost'] = $variant['unit_cost'];
                $operation['unit_commission'] = $variant['unit_commission'];
                $ids[]   = $this->stock_operation_repository->create($operation);
                $this->VariantStockService->UpdateStock($variant['id'],$variant['quantity']);
            }
        }

        if(isset($details['image']) && count($ids) > 0){
            $file = $this->FileUploadService->handle($details['image'],'stock',$user->company_id);
            foreach ($ids as $id) {
                $file->collection_id = $id;
                $this->MediaService->save($file);
            }
        }

        $invoice_info = $this->VariantStockService->GetInvoiceInfo($details['product_variants'], $details['supplier_id']);
        $invoice_id = $this->InvoiceService->AddInvoice($invoice_info);
        $this->stock_operation_repository->update_invoice_id($ids,$invoice_id);
        $this->OrdersRepository->update_incomplete_orders_status();

        return $ids;
    }

    function sell($user,$details) {
        $operation['admin_id'] = $user->id;
        $operation['company_id'] = $user->company_id;
        $operation['type'] = $details['type'];
        $operation['order_id'] = $details['order_id'];

        $keys = array_column($details['items'],'id');
        $warehouses = array_column($details['items'],'warehouse_id');
        $unit_sales = array_column($details['items'],'unit_sale');

        $map_warehouses = array_combine($keys, $warehouses);
        $map_unit_sales = array_combine($keys, $unit_sales);

        $items = $this->GetVariantsUnitValues($details['items']);

        $ids = [];
        foreach ($items as $item) {
            $operation['variant_id'] = $item['id'];
            $operation['warehouse_id'] = $map_warehouses[$item['id']];
            $operation['quantity'] = $item['quantity'] * -1;
            $operation['unit_price'] = $item['unit_price'];
            $operation['unit_price_after_sale'] = $map_unit_sales[$item['id']];
            $operation['unit_cost'] = $item['unit_cost'];
            $operation['unit_commission'] = $item['unit_commission'];

            $ids[] = $this->stock_operation_repository->create($operation);
            $this->VariantStockService->UpdateStock($item['id'],$operation['quantity']);
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

        return true;
    }

    function GetVarintsStock($variant_id,$user) {
        return $this->stock_operation_repository->get_variant_stock_warehouse($variant_id,$user);
    }

    public function CheckItemsAvailable($items) {
        foreach ($items as $item) {
            $stock = (int)$this->stock_operation_repository->get_variant_stock_by_warehouse_id($item['id'],$item['warehouse_id']);
            if($stock < (int)$item['quantity']){
                return false;
            }
        }
        return true;
    }

    private function GetVariantsUnitValues($items)
    {
        foreach ($items as $key => $item) {
            if(!$item['quantity']){
                unset($items[$key]);
            }
        }
        $ids = array_column($items,"id");
        $qtys = array_column($items,"quantity");
        $map = array_combine($ids,$qtys);
        $values = $this->VariantStockService->GetUnitValues($ids);
        $variants = array();
        $i=0;
        foreach ($values as $variant) {
            $variants[$i]['id'] = $variant->id;
            $variants[$i]['quantity'] = $map[$variant->id];
            $variants[$i]['unit_price'] = $variant->price;
            $variants[$i]['unit_cost'] = $variant->product->cost;
            $variants[$i]['unit_commission'] = $variant->product->marketer_commission;
            $i++;
        }

        return $variants;
    }
    public function ScanStock($data)
    {
        return $this->stock_operation_repository->get_scan_stock($data);
    }
    public function UpdateStock($order_id ,$data)
    {
        return $this->stock_operation_repository->update_stock($order_id ,$data);
    }
    public function DeleteStock($id)
    {
        return $this->stock_operation_repository->DeleteStock($id);
    }
    public function AddStock($new_items)
    {
        return $this->stock_operation_repository->AddStock($new_items);
    }

}
