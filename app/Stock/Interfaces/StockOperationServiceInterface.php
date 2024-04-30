<?php
namespace App\Stock\Interfaces;

interface StockOperationServiceInterface{

    public function CreateOperation($user,array $details);
    public function GetCompanyStock($company_id,$filters);
    public function CheckItemsAvailable($items);
    public function UpdateStock($order_id, $data);
    public function DeleteStock($variant_id);
    public function AddStock($new_items);
}
