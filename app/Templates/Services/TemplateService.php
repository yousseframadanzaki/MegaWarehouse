<?php 

namespace App\Templates\Services;

use App\Templates\Interfaces\TemplateRepositoryInterface;
use App\Templates\Interfaces\TemplateServiceInterface;


class TemplateService implements TemplateServiceInterface{
   
    public function __construct(
        protected readonly TemplateRepositoryInterface $template_repository
    ) {}
    
    public function AddTemplate($company_id,$data)
    {
        $data['company_id'] = $company_id;
        return $this->template_repository->create_template($data);
    }
    
    public function GetTemplate($template_id)
    {
        return $this->template_repository->get_template_by_id($template_id);
    }
    
    public function GetCompanyTemplates($company_id)
    {
        return $this->template_repository->get_templates_by_company_id($company_id);
    }
    
    public function UpdateTemplate($template_id,$data)
    {
        return $this->template_repository->update_template_by_id($template_id,$data);
    }
    

}