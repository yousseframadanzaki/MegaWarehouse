<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Templates\Requests\CreateTemplateRequest;
use App\Templates\Requests\UpdateTemplateRequest;

use App\Templates\Interfaces\TemplateServiceInterface;

class TemplateController extends Controller
{

    public function __construct(
        protected readonly TemplateServiceInterface $TemplateService
    ) {}

    public function all()
    {
        $templates = $this->TemplateService->GetCompanyTemplates($this->company_id());
        return view('Dashboard.Templates.show_all')->with('templates',$templates);
    }


    public function create()
    {
        return view('Dashboard.Templates.add');
    }

    public function store(CreateTemplateRequest $request)
    {
        if(!$this->TemplateService->AddTemplate($this->company_id(),$request->validated())){
            return redirect()->back()->with('error','template_add_error');
        }
        return redirect()->back()->with('success','template_add_success');
    }

    public function edit($template_id)
    {
        $template = $this->TemplateService->GetTemplate($template_id);
        return view('Dashboard.Templates.edit')->with('template',$template);
    }

    public function update(UpdateTemplateRequest $request, string $template_id)
    {
        if(!$this->TemplateService->UpdateTemplate($template_id,$request->validated())){
            return redirect()->back()->with('error','template_update_error');
        }
        return redirect()->back()->with('success','template_update_success');
    }
}
