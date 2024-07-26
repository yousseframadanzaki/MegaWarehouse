<?php
namespace App\Products\Interfaces;

interface VariantStockServiceInterface{
    public function UpdateStock($variant_id);
    public function GetInvoiceInfo($variants, $supplier_id);
    public function GetUnitValues($variants);
    public function get_scan_items($ids);
    public function update_varient_stock_shelf($variant_id, $shelf);
}
