<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;

class AccountingController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private TransactionServiceInterface $TransactionService;

    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        TransactionServiceInterface $TransactionService
    ) {
        $this->CommonDataService = $CommonDataService;
        $this->TransactionService = $TransactionService;
    }

    public function all()
    {
        $company_id = $this->company_id();
        $transactions = $this->TransactionService->GetCompanyTransactions($company_id);
        return view('Dashboard.Accounting.show_all')->with('transactions',$transactions);
    }

    public function create()
    {
        $company_id = $this->company_id();
        $users = $this->CommonDataService->GetCompanyUsers($company_id);
        $suppliers = $this->CommonDataService->GetCompanySuppliers($company_id);
        $payment_categories = $this->CommonDataService->GetPaymentTypesCategories();

        return view('Dashboard.Accounting.add', compact('users', 'suppliers', 'payment_categories'));
    }

    public function get_payments($category)
    {
        return $this->CommonDataService->GetPaymentTypesByCategory($category);
    }
}
