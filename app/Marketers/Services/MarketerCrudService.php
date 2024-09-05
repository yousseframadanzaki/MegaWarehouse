<?php

namespace App\Marketers\Services;

use App\Marketers\Interfaces\MarketerCrudRepositoryInterface;
use App\Marketers\Interfaces\MarketerCrudServiceInterface;
use App\Users\Interfaces\UserCrudServiceInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

class MarketerCrudService implements MarketerCrudServiceInterface{

    public function __construct(
        protected readonly MarketerCrudRepositoryInterface $marketer_crud_repository,
        protected readonly UserCrudServiceInterface $UserCrudService,
        protected readonly UploadServiceInterface $FileUploadService,
        protected readonly MediaCrudServiceInterface $MediaCrudService
    ) {}

    public function CreateMarketer($company_id,array $details){
        if(isset($details['links'])){
            $details['links'] = json_encode($details['links'],true);
        }
        $user_details = array(
            'name'=>$details['name'],
            'email'=>$details['email'],
            'password'=>$details['password'],
            'phone_1'=>$details['phone_number'],
            'role_id'=>$details['role_id'],
        );
        $user = $this->UserCrudService->CreateUser($user_details,$company_id);

        $marketer_details = array(
            'name'=>$details['name'],
            'phone_number'=>$details['phone_number'],
            'page_name'=>$details['page_name'],
            'links'=>$details['links'],
            'company_id'=>$company_id,
            'user_id'=>$user->id,
            'company_id'=>$company_id,
        );

        $marketer = $this->marketer_crud_repository->create_marketer($marketer_details);
        if (!empty($details['images'])) {
            $image = $this->FileUploadService->handle($details['images'],'avatar',$company_id,$marketer->user->id);
            $this->MediaCrudService->save($image);
        }
        return $marketer;
    }

    public function UpdateMarketer($marketer_id,array $details){
        $user_id = $this->GetMarketer($marketer_id)->user_id;
        $this->UserCrudService->UpdateUser($user_id, ['name'=>$details['name'], 'phone_1'=>$details['phone']]);
        return $this->marketer_crud_repository->update_marketer($marketer_id,$details);
    }

    public function GetCompanyMarketers($company_id){
        return $this->marketer_crud_repository->get_marketers_by_company_id($company_id);
    }

    public function GetMarketer($id){

       return $this->marketer_crud_repository->get_marketer_by_id($id);
    }

    public function GetMarketerBalanceData($marketer_id) {
        return $this->marketer_crud_repository->get_marketer_balance_data($marketer_id);
    }
}
