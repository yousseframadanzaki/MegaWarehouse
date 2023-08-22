<?php 

namespace App\Templates\Interfaces;

interface TemplateServiceInterface{
    public function AddTemplate($company_id,$data);
    
    public function GetTemplate($template_id);
    
    public function GetCompanyTemplates($company_id);
    
    public function UpdateTemplate($template_id,$data);
}