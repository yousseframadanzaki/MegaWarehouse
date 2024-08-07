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
        $payment_categories = $this->CommonDataService->GetPaymentTypesCategories();

        return view('Dashboard.Accounting.add', compact('payment_categories'));
    }

    public function store(CreateTransactionRequest $request)
    {
        $transactionData = $request->except('_token');
        $transactionData['company_id'] = $this->company_id();
        $this->TransactionService->AddTransaction($transactionData);
        return redirect()->route('all_transactions')->with('success', trans('global.created_success'));
    }

    public function get_payment_category_data($payment_category)
    {
        $payment_types = $this->CommonDataService->GetPaymentTypesByCategory($payment_category);

        $user_type = [
            "Transfer" => 1, // 1 referes to manager
            "Invoices" => 2, // 2 referes to supplier
            "Commissions" => 3, // 3 referes to marketer
            "Shipping Accounting" => 4, // 4 referes to shipping_company
        ];

        $from_users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 1)->pluck('name', 'id');
        $to_users = ($payment_category != "Expense") ? $this->CommonDataService->GetUsersByRoleType($this->company_id(), $user_type[$payment_category])->pluck('name', 'id') : [];

        return response()->json([
            'payment_types' => $payment_types,
            'from_users' => $from_users,
            'to_users' => $to_users
        ]);
    }

    public function get_payment_type_userdata($payment_type_id) {
        if ($payment_type_id == 9) {
            $from_users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 4)->pluck('name', 'id');
            $to_users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 1)->pluck('name', 'id');
        } else {
            $from_users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 1)->pluck('name', 'id');
            $to_users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 4)->pluck('name', 'id');
        }

        return response()->json([
            'from_users' => $from_users,
            'to_users' => $to_users
        ]);
    }

    public function get_company_users_by_user_type($payment_category) {

    }
}
