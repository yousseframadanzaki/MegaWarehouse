<?php

namespace App\Accounting\Repositories;

use App\Models\Transaction;

use App\Accounting\Interfaces\TransactionRepositoryInterface;


class TransactionRepository implements TransactionRepositoryInterface{
    public function get_sum_by_invoice_id($invoice_id){
        return Transaction::where(['invoice_id'=>$invoice_id])->sum('value');
    }
    public function create_transaction($data){
        return Transaction::create($data);
    }
    public function get_transactions_by_company_id($company_id){
        return Transaction::with([
            'from_user',
            'to_user',
            'order',
            'payment_type',
        ])->where('company_id',$company_id)
        ->orderBy('created_at','DESC')
        ->paginate(20);
    }
}