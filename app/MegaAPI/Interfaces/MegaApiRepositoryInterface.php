<?php

namespace App\MegaAPI\Interfaces;

interface MegaApiRepositoryInterface{
    public function get_mega_company_id($name,$password,$url);
    public function get_mega_company_statuses($name,$password,$url);
    public function get_mega_company_sectors($name,$password,$url,$mega_company_id);
    public function create_new_shipment($name,$password,$url,$shipment);
}