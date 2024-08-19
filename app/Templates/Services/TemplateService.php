<?php

namespace App\Templates\Services;

use App\Templates\Interfaces\TemplateRepositoryInterface;
use App\Templates\Interfaces\TemplateServiceInterface;


class TemplateService implements TemplateServiceInterface
{

    public function __construct(
        protected readonly TemplateRepositoryInterface $template_repository
    ) {
    }

    public function AddTemplate($company_id, $data)
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

    public function UpdateTemplate($template_id, $data)
    {
        return $this->template_repository->update_template_by_id($template_id, $data);
    }

    public function GetTextFromOrdersTemplates($order)
    {
        $templates = $this->template_repository->get_templates_by_type('orders', $order->company_id);
        $find = [
            '#order_id',
            '#waybill',
            '#client_name',
            '#client_phone_1',
            '#client_phone_2',
            '#address',
            '#city',
            '#area',
            '#total',
            '#status',
            "\n",
        ];

        $replace = [
            $order->order_code,
            $order->waybill,
            $order->name,
            $order->phone_1,
            $order->phone_2,
            $order->address,
            $order->city->name,
            $order->area->name,
            $order->total_after_sale,
            $order->status->name,
            "<br>"
        ];
        $texts = array();

        foreach ($templates as $template) {
            $texts[] = str_replace($find, $replace, $template->text);
        }
        return $texts;
    }

    public function GetTextFromClientsTemplates($client)
    {
        $templates = $this->template_repository->get_templates_by_type('clients', $client->company_id);
        $find = [
            '#client_name',
            '#address',
            "\n",
        ];

        $replace = [
            $client->name,
            $client->address,
            "<br>"
        ];
        $texts = array();

        foreach ($templates as $template) {
            $texts[] = str_replace($find, $replace, $template->text);
        }
        return $texts;
    }
}
