<?php

namespace App\MegaAPI\Services;

use App\MegaAPI\Interfaces\MegaApiRepositoryInterface;
use App\MegaAPI\Interfaces\MegaApiServiceInterface;

class MegaApiService implements MegaApiServiceInterface{
    
    public function __construct(
        protected readonly MegaApiRepositoryInterface $mega_api_repository
    ) {}

    public function GetMegaCompanyId($name,$password,$url){
        return $this->mega_api_repository->get_mega_company_id($name,$password,$url);
    }
    public function GetMegaStatusNames($name,$password,$url){
        return $this->mega_api_repository->get_mega_company_statuses($name,$password,$url);
    }
    public function GetMegaCompanySectors($name,$password,$url,$mega_company_id){
        return $this->mega_api_repository->get_mega_company_sectors($name,$password,$url,$mega_company_id);
    }
    public function UpdateShipment($name,$password,$url,$shipment){
        return $this->mega_api_repository->update_shipment($name,$password,$url,$shipment);
    }
    public function CreateNewShipment($name,$password,$url,$shipment){
        return $this->mega_api_repository->create_new_shipment($name,$password,$url,$shipment);
    }
    public function CreateNewShipmentV2($name,$password,$url,$shipment){
        return $this->mega_api_repository->create_new_shipment($name,$password,$url,$shipment);
    }
}