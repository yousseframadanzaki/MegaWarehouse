<?php

namespace App\Marketers\Interfaces;

interface MarketerCrudRepositoryInterface{
    public function create_marketer(array $details);
    public function update_marketer($marketer_id,array $details);
    public function get_marketers_by_company_id($company_id);
    public function get_marketer_by_id($id);
}