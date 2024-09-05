<?php

namespace App\Marketers\Interfaces;

interface MarketerCrudServiceInterface{
    public function CreateMarketer($company_id,array $details);
    public function UpdateMarketer($client_id,array $details);
    public function GetCompanyMarketers($company_id);
    public function GetMarketer($client_id);
    public function GetMarketerBalanceData($marketer_id);
}
