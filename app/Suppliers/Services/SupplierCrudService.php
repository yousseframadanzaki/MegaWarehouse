<?php

namespace App\Suppliers\Services;

use App\Suppliers\Interfaces\SupplierCrudRepositoryInterface;
use App\Suppliers\Interfaces\SupplierCrudServiceInterface;
use App\Users\Interfaces\UserCrudServiceInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

class SupplierCrudService implements SupplierCrudServiceInterface{



    public function __construct(
        protected readonly SupplierCrudRepositoryInterface $supplier_crud_repository,
        protected readonly UserCrudServiceInterface $UserCrudService,
        protected readonly UploadServiceInterface $FileUploadService,
        protected readonly MediaCrudServiceInterface $MediaCrudService
    ) {}

    public function CreateSupplier($company_id,array $details){
        $user_details = array(
            'name'=>$details['name'],
            'email'=>$details['email'],
            'password'=>$details['password'],
            'phone_1'=>$details['phone'],
            'role_id'=>$details['role_id'],
        );
        $user = $this->UserCrudService->CreateUser($user_details,$company_id);
        $supplier_details = array(
            'name'=>$details['name'],
            'phone'=>$details['phone'],
            'address'=>$details['address'],
            'user_id'=>$user->id,
            'company_id'=>$company_id,
        );
        $supplier = $this->supplier_crud_repository->add_supplier($supplier_details);
        if (!empty($details['images'])) {
            $image = $this->FileUploadService->handle($details['images'],'supplier',$company_id,$supplier->id);
            $this->MediaCrudService->save($image);
        }
        return $supplier;
    }

    public function UpdateSupplier($supplier_id,array $details){
        $user_id = $this->GetSupplier($supplier_id)->user_id;
        $this->UserCrudService->UpdateUser($user_id, ['name'=>$details['name'], 'phone_1'=>$details['phone']]);
        return $this->supplier_crud_repository->update_supplier_by_id($supplier_id,$details);
    }

    public function GetCompanySuppliers($company_id){
        return $this->supplier_crud_repository->get_company_suppliers($company_id);
    }

    public function GetSupplier($id){
        return $this->supplier_crud_repository->get_supplier_by_id($id);
    }

    public function GetSupplierWithProducts($id){
        return $this->supplier_crud_repository->get_supplier_with_products($id);
    }

}
