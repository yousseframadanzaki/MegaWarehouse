<?php

namespace App\ShippingCompanies\Services;

use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\ShippingAreas\Interfaces\ShippingAreaServiceInterface;

use App\MegaAPI\Interfaces\MegaApiServiceInterface;

class ShippingCompanyService implements ShippingCompanyServiceInterface{


    public function __construct(
        protected readonly ShippingCompanyRepositoryInterface $shipping_company_repository,
        protected readonly ShippingAreaServiceInterface $ShippingAreaService,
        protected readonly MegaApiServiceInterface $MegaApiService
    ) {}

    public function AddShippingCompany($company_id,$data){
        $data['mega_company_id'] = $this->MegaApiService
            ->GetMegaCompanyId(
                $data['username'],
                $data['password'],
                $data['url']
            );
        // $data['mega_company_id'] = '1';
        if(empty($data['mega_company_id'])){
            return false;
        }
        $data['company_id'] = $company_id;
        return $this->shipping_company_repository->create_shipping_company($data);
    }

    public function GetCompanyShippingCompanies($company_id){
        return $this->shipping_company_repository->get_shipping_companies_by_company_id($company_id);
    }
    
    public function GetShippingCompany($shipping_company_id){
        return $this->shipping_company_repository->get_shipping_company_by_id($shipping_company_id);
    }

    public function UpdateShippingCompany($shipping_company_id,$data){
        $data['mega_company_id'] = $this->MegaApiService
            ->GetMegaCompanyId(
                $data['username'],
                $data['password'],
                $data['url']
            );
        // $data['mega_company_id'] = '1';
        if(empty($data['mega_company_id'])){
            return false;
        }
        return $this->shipping_company_repository->update_shipping_company_by_id($shipping_company_id,$data);
    }

    public function SendShipment($order,$shipping_company_id){
        $shipping_company = $this->GetShippingCompany($shipping_company_id);

        $shipment = $this->ShipmentInfoFromOrder($order,$shipping_company_id);

        // dd($shipment);

        if(!$shipment){
            return false;
        }

        $shipment_info = $this->MegaApiService
        ->CreateNewShipment(
            $shipping_company->username,
            $shipping_company->password,
            $shipping_company->url,
            $shipment
        );
        
        return $shipment_info;
    }

    private function ShipmentInfoFromOrder($order,$shipping_company_id)
    {
        
        $sector_id = $this->ShippingAreaService->GetAreaSectorIdMapping($order->area_id,$shipping_company_id);
        if(!$sector_id){
            return false;
        }
        $product_name = "";
        foreach ($order->items as $order_item) {
           $product_name .= $order_item->product->name . "({{$order_item->pivot->quantity}}) - ";
        }
        $phone_1 = $order->phone_1;
        $phone_2 = $order->phone_2;
        $price = $order->total;
        $address = $order->address;
        $client_name = $order->name;
        $order_id = $order->order_code;
        $shipment = array(
            'sector_id' =>$sector_id,
            'product_name' =>$product_name,
            'phone_1' =>$phone_1,
            'phone_2' =>$phone_2,
            'price' =>$price,
            'address' =>$address,
            'client_name' =>$client_name,
            'order_id' =>$client_name
        );
        return $shipment;
    }

}