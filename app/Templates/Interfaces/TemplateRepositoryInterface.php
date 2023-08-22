<?php 

namespace App\Templates\Interfaces;

interface TemplateRepositoryInterface{
    public function create_template($data);

    public function get_template_by_id($template_id);

    public function get_templates_by_company_id($company_id);

    public function update_template_by_id($template_id,$data);

    public function get_templates_by_type($type,$company_id);
}