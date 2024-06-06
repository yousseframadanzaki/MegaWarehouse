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
}
