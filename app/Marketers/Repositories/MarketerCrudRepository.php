<?php

namespace App\Marketers\Repositories;

use App\Marketers\Interfaces\MarketerCrudRepositoryInterface;

use App\Models\Marketer;
use App\Models\Order;
use App\Models\Transaction;

class MarketerCrudRepository implements MarketerCrudRepositoryInterface{

    public function create_marketer(array $details){
        return Marketer::create($details);
    }

    public function update_marketer($marketer_id,array $details){
        return Marketer::where(['id'=>$marketer_id])->update($details);
    }

    public function get_marketers_by_company_id($company_id){
        return Marketer::withCount('orders')
        ->withSum('orders AS total_commission', 'total_marketer_commission')
        ->with('user', function($query) {
            $query->withSum('to_transactions AS total_transactions', 'value');
        })
        ->where('company_id',$company_id)
        ->paginate(10);
    }

    public function get_marketer_by_id($id){
        $marketer = Marketer::withCount('orders')
        ->withSum('orders AS total_commission', 'total_marketer_commission')
        ->with('user', function($query) {
            $query->withSum('to_transactions AS total_transactions', 'value');
        })
        ->find($id);
        return $marketer;
    }

    public function get_marketer_balance_data($marketer_id) {
        $company_id = auth()->user()->company_id;
        $marketer = Marketer::with('user')->findOrFail($marketer_id);

        $marketer_orders = Order::select(['id', 'total_marketer_commission'])
            ->where(['company_id' => $company_id, 'marketer_id' => $marketer_id])
            ->whereHas('order_status', function($query) {
                $query->whereIn('order_status.status_id', [45, 50, 55]);
            })
            ->get();

        $marketer_transactions = Transaction::with(['from_user', 'to_user', 'payment_type'])->where(['company_id' => $company_id,'to' => $marketer->user->id, 'payment_type_id' => 3])->paginate(50);

        $data = [
            'marketer' => $marketer,
            'marketer_orders' => $marketer_orders,
            'marketer_transactions' => $marketer_transactions,
            'marketer_commissions' => $marketer_orders->sum('total_marketer_commission'),
            'paid_commissions' => $marketer_transactions->sum('value')
        ];

        return $data;
    }
}
