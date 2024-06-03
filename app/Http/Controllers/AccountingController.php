<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Accounting\Requests\CreateTransactionRequest;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;
use App\Accounting\Filters\TransactionsFilters;

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

    public function all(TransactionsFilters $filters)
    {
        $company_id = $this->company_id();
        $transactions = $this->TransactionService->GetCompanyTransactions($company_id, $filters);
        $users = $this->CommonDataService->GetCompanyUsers($company_id);
        $payment_categories = $this->CommonDataService->GetPaymentTypesCategories();
        $filters = $filters->get_values();

        return view('Dashboard.Accounting.show_all', compact('transactions', 'users', 'payment_categories', 'filters'));
    }

    public function create()
    {
        $company_id = $this->company_id();
        $users = $this->CommonDataService->GetCompanyUsers($company_id);
        $suppliers = $this->CommonDataService->GetCompanySuppliers($company_id);
        $payment_categories = $this->CommonDataService->GetPaymentTypesCategories();

        return view('Dashboard.Accounting.add', compact('users', 'suppliers', 'payment_categories'));
    }

    public function store(CreateTransactionRequest $request)
    {
        $transactionData = $request->all();
        $transactionData['company_id'] = $this->company_id();
        $this->TransactionService->AddTransaction($transactionData);
        return redirect()->route('all_transactions')->with('success', 'Transaction_added_successfully');
    }

    public function get_payments($category)
    {
        return $this->CommonDataService->GetPaymentTypesByCategory($category);
    }
}
