<?php

namespace App\Accounting\Interfaces;

interface TransactionRepositoryInterface{
    public function get_sum_by_invoice_id($invoice_id);
    public function create_transaction($data);
    public function get_transactions_by_company_id($company_id, $filters);
    public function get_transactions_by_user_id($company_id, $user_id);
}
