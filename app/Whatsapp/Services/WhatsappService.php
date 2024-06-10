<?php

namespace App\Whatsapp\Services;

use App\Whatsapp\Interfaces\WhatsappRepositoryInterface;
use App\Whatsapp\Interfaces\WhatsappServiceInterface;



class WhatsappService implements WhatsappServiceInterface
{

    public function __construct(
        protected readonly  WhatsappRepositoryInterface $whatsapp_crud_repository,
    ) {
    }
    public function AddPoints($data){
        return $this->whatsapp_crud_repository->add_points($data);
    }
    public function GetUserPoints($user_id){
        return $this->whatsapp_crud_repository->get_user_points($user_id);
    }
    public function GetDevices($user_id){
        return $this->whatsapp_crud_repository->get_devices($user_id);
    }
    public function AddDevice($data){
        return $this->whatsapp_crud_repository->add_device($data);
    }
    public function DeleteDevice($device_id){
        return $this->whatsapp_crud_repository->delete_device($device_id);
    }
    public function StoreCampagin($data){
        return $this->whatsapp_crud_repository->store_campagin($data);
    }
}
