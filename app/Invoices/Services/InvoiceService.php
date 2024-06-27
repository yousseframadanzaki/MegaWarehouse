<?php

namespace App\Invoices\Services;

use App\Invoices\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Interfaces\InvoiceServiceInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

class InvoiceService implements InvoiceServiceInterface{

    public function __construct(
       protected readonly InvoiceRepositoryInterface $invoice_repository,
       protected readonly TransactionServiceInterface $TransactionService,
       protected readonly UploadServiceInterface $FileUploadService,
       protected readonly MediaCrudServiceInterface $MediaCrudService,

    ) {}

    public function AddInvoice($invoice_info){
        return $this->invoice_repository->create_invoice($invoice_info);
    }

    public function GetCompanyInvoices($company_id,$filters){
        return $this->invoice_repository->get_invoices_by_company_id($company_id,$filters);
    }

    public function GetInvoice($invoice_id){
        return $this->invoice_repository->get_invoice_by_id($invoice_id);
    }

    public function PayInvoice($invoice_id,$data){
        $invoice = $this->invoice_repository->get_invoice_no_relations($invoice_id);
        $transaction_data = array(
            'from'=>$data['from'],
            'to'=>$invoice->supplier->user_id,
            'value'=>$data['value'],
            'note'=>$data['note'],
            'invoice_id'=>$invoice->id,
            'company_id'=>$invoice->company_id
        );
        if(isset($data['image']) && !empty($data['image'])){
            $image_file = $data['image'];
            unset($data['image']);
            $image = $this->FileUploadService->handle($image_file,'transaction',$invoice->company_id,$invoice->id);
            $this->MediaCrudService->save($image);
        }
        return $this->TransactionService->AddInvoiceTransaction($transaction_data);
    }
}
