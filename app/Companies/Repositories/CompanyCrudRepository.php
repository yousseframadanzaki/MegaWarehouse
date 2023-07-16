<?php

namespace App\Companies\Repositories;

use App\Models\Company;
use App\Companies\Interfaces\CompanyCrudRepositoryInterface;

class CompanyCrudRepository implements CompanyCrudRepositoryInterface{
    
    public function add_company(array $company_details) {
        return Company::Create($company_details);
    }

    public function get_all_companies(){
        return Company::all()->sortByDesc('created_at');
    }

    public function get_company_by_id($company_id){
        return Company::findOrfail($company_id);
    }

    public function update_column($company_id,$column,$value){
        $company = Company::find($company_id);
        $company[$column] = $value;
        return $company->save();
    }

    public function update_company_by_id($company_id,array $company_details){
        return Company::where('id',$company_id)->update($company_details);
    }
    
}