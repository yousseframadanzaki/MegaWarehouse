<?php

namespace App\ShippingStatus\Services;

use App\ShippingStatus\Interfaces\ShippingStatusRepositoryInterface;
use App\ShippingStatus\Interfaces\ShippingStatusServiceInterface;

use App\MegaAPI\Interfaces\MegaApiServiceInterface;

class ShippingStatusService implements ShippingStatusServiceInterface{


    public function __construct(
        protected readonly ShippingStatusRepositoryInterface $shipping_status_repository,
        protected readonly MegaApiServiceInterface $MegaApiService
    ) {}

    public function GetShippingCompanyStatuses($shipping_company){
        $shipping_company_statuses = $this->MegaApiService
        ->GetMegaStatusNames(
            $shipping_company->username,
            $shipping_company->password,
            $shipping_company->url
        );

        $shipping_statuses = $this->shipping_status_repository
        ->get_shipping_statuses_by_shipping_company($shipping_company->id);

        if(!$shipping_statuses){
            return $shipping_company_statuses;
        }
        
        return $this->pair($shipping_statuses,$shipping_company_statuses);
    }

    private function pair($shipping_statuses,$shipping_company_statuses)
    {
        $statuses = array();
        foreach ($shipping_company_statuses as $shipping_company_status) {
            $status = $shipping_statuses->firstWhere('shipping_company_status_id',$shipping_company_status['id']);
            $shipping_company_status['status_id'] = isset($status) ?  $status->status_id : NULL;
            $shipping_company_status['status_mapping_id'] = isset($status) ?  $status->id : NULL;
            $statuses[] = $shipping_company_status;
        }
        return $statuses;
    }

    public function UpsertMapping($data)
    {
        return $this->shipping_status_repository->upsert_mapping($data);
    }

}