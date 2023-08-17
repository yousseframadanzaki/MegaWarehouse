<?php

namespace App\MegaAPI\Repositories;

use App\MegaAPI\Interfaces\MegaApiRepositoryInterface;
use Illuminate\Support\Facades\Http;

class MegaApiRepository implements MegaApiRepositoryInterface{
    public function get_mega_company_id($name,$password,$url){
        $response = Http::get($url.'/megawarehouse/get_company_id.php', [
            'user' => $name,
            'password' => $password,
        ]);
        $data = $response->json();
        return $data['mega_company_id'];
    }

    public function get_mega_company_statuses($name,$password,$url){
        $response = Http::get($url.'/megawarehouse/get_status_names.php', [
            'user' => $name,
            'password' => $password,
        ]);
        $data = $response->json();
        return $data;
    }

    public function get_mega_company_sectors($name,$password,$url,$mega_company_id){
        $response = Http::get($url.'/megawarehouse/get_company_sectors.php', [
            'user' => $name,
            'password' => $password,
            'mega_company_id' => $mega_company_id,
        ]);
        $data = $response->json();
        return $data;
    }
    
}