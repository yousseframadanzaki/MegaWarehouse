<?php

namespace App\Marketers\Services;

use App\Marketers\Interfaces\MarketerCrudRepositoryInterface;
use App\Marketers\Interfaces\MarketerCrudServiceInterface;

class MarketerCrudService implements MarketerCrudServiceInterface{

    protected MarketerCrudRepositoryInterface $marketer_crud_repository;

    public function __construct(
        MarketerCrudRepositoryInterface $marketer_crud_repository
    ) {
        $this->marketer_crud_repository = $marketer_crud_repository;
    }

    public function CreateMarketer($company_id,array $details){
        $details['company_id'] = $company_id;
        if(isset($details['links'])){
            $details['links'] = json_encode($details['links'],true);
        }
        $marketer = $this->marketer_crud_repository->create_marketer($details);
        return $marketer;
    }

    public function UpdateMarketer($marketer_id,array $details){
        return $this->marketer_crud_repository->update_marketer($marketer_id,$details);
    }

    public function GetCompanyMarketers($company_id){
        return $this->marketer_crud_repository->get_marketers_by_company_id($company_id);       
    }

    public function GetMarketer($id){
        return $this->marketer_crud_repository->get_marketer_by_id($id);
    }
    
}