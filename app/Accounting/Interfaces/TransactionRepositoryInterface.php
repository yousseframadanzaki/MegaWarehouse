<?php

namespace App\Accounting\Interfaces;

interface TransactionRepositoryInterface{
    public function get_sum_by_invoice_id($invoice_id);
    public function create_transaction($data);
}