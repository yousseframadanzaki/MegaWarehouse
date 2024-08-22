<?php

namespace App\ShippingAreas\Services;

use App\ShippingAreas\Interfaces\ShippingAreaRepositoryInterface;
use App\ShippingAreas\Interfaces\ShippingAreaServiceInterface;

use App\MegaAPI\Interfaces\MegaApiServiceInterface;

class ShippingAreaService implements ShippingAreaServiceInterface{


    public function __construct(
        protected readonly ShippingAreaRepositoryInterface $shipping_area_repository,
        protected readonly MegaApiServiceInterface $MegaApiService
    ) {}

    public function GetShippingCompanyAreas($shipping_company){
        $shipping_company_areas = $this->MegaApiService
        ->GetMegaCompanySectors(
            $shipping_company->username,
            $shipping_company->password,
            $shipping_company->url,
            $shipping_company->mega_company_id
        );

        $shipping_areas = $this->shipping_area_repository
        ->get_shipping_areas_by_shipping_company($shipping_company->id);

        if(!$shipping_areas){
            return $shipping_company_areas;
        }

        return $this->pair($shipping_areas,$shipping_company_areas);
    }

    private function pair($shipping_areas,$shipping_company_areas)
    {
        if (empty($shipping_company_areas)) {
            $shipping_company_areas = [];
        }

        $areas = array();
        foreach ($shipping_company_areas as $shipping_company_area) {
            $area = $shipping_areas->firstWhere('shipping_company_sector_id',$shipping_company_area['id']);
            $shipping_company_area['area_id'] = isset($area) ?  $area->area_id : NULL;
            $shipping_company_area['area_mapping_id'] = isset($area) ?  $area->id : NULL;
            $areas[] = $shipping_company_area;
        }
        return $areas;
    }

    public function UpsertMapping($data)
    {
        return $this->shipping_area_repository->upsert_mapping($data);
    }
    public function GetAreaSectorIdMapping($area_id,$shipping_company_id){
        return $this->shipping_area_repository->get_area_sector_id($area_id,$shipping_company_id);
    }

    public function UpdateShippingAreaActive2($data) {
        $shipping_areas = $data['shipping_areas'];
        foreach ($shipping_areas as $shipping_area) {
            if ($shipping_area['shipping_co_cost'] != '' && $shipping_area['shipping_co_cost'] >= 0) {
                $shipping_area['shipping_company_id'] = $data['shipping_company_id'];
                $this->shipping_area_repository->update_shipping_area_active2($shipping_area);
            }
        }

        return true;
    }
}
