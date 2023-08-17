<?php

namespace App\MegaAPI\Interfaces;

interface MegaApiServiceInterface{
    public function GetMegaCompanyId($name,$password,$url);
    public function GetMegaStatusNames($name,$password,$url);
    public function GetMegaCompanySectors($name,$password,$url,$mega_company_id);
}