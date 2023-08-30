<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Accounting\Interfaces\TransactionServiceInterface;

class AccountingController extends Controller
{
    public function __construct(
        protected readonly TransactionServiceInterface $TransactionService
    ) {}

    public function all()
    {
        $company_id = $this->company_id();
        $transactions = $this->TransactionService->GetCompanyTransactions($company_id);
        return view('Dashboard.Accounting.show_all')->with('transactions',$transactions);
    }

}
