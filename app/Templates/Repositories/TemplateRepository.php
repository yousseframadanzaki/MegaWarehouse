<?php 

namespace App\Templates\Repositories;

use App\Templates\Interfaces\TemplateRepositoryInterface;

use App\Models\Template;



class TemplateRepository implements TemplateRepositoryInterface{
    public function create_template($data)
    {
        return Template::create($data);
    }

    public function get_template_by_id($template_id)
    {
        return Template::findOrFail($template_id);
    }

    public function get_templates_by_company_id($company_id)
    {
        return Template::where(['company_id'=>$company_id])->get();
    }

    public function update_template_by_id($template_id,$data)
    {
        return Template::where(['id'=>$template_id])->update($data);
    }

}