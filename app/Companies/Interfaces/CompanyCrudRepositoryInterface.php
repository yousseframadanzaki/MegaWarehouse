<?php

namespace App\Companies\Interfaces;

interface CompanyCrudRepositoryInterface{
    public function add_company(array $company_details);
    public function get_all_companies();
    public function update_column($company_id,$column,$value);
    public function get_company_by_id($company_id);
    public function update_company_by_id($company_id,array $company_details);
}