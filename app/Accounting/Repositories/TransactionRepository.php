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
}