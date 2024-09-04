<?php

namespace App\ProfitReports\Repositories;

use App\ProfitReports\Interfaces\ProfitReportRepositoryInterface;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Transaction;

class ProfitReportRepository implements ProfitReportRepositoryInterface {
    public function get_report_stats() {
        $company_id = auth()->user()->company_id;
        $order_query = Order::where('company_id', $company_id)
            ->whereHas('order_status', function ($query) {
                $query->whereIn('order_status.status_id', [45, 50, 55]);
            });

        $order_ids = $order_query->clone()->pluck('id')->toArray();
        $orders_aggregated = $order_query->selectRaw('
            COALESCE(SUM(shipping_co_cost), 0) AS sum_shipping_co_cost,
            COALESCE(SUM(total_marketer_commission), 0) AS sum_total_marketer_commission,
            COALESCE(SUM(total_after_sale), 0) AS sum_total_after_sale,
            COUNT(id) AS total_orders
            ')
            ->first();

        $paid_commissions = Transaction::where(['company_id' => $company_id, 'payment_type_id' => 3])->sum('value');
        $orders_cost = Stock::where('type', 'sell')->whereIn('order_id', $order_ids)->selectRaw('COALESCE(SUM(ABS(quantity) * unit_cost), 0) as total_orders_cost')->value('total_orders_cost');
        $expenses = Transaction::where(['company_id' => $company_id])
            ->whereHas('payment_type', function($query) {
                $query->where('category', 'Expense');
            })->sum('value');

        $data = [
            'total_orders' => $orders_aggregated->total_orders,
            'sum_total_after_sale' => $orders_aggregated->sum_total_after_sale,
            'sum_shipping_co_cost' => $orders_aggregated->sum_shipping_co_cost,
            'sum_total_marketer_commission' => $orders_aggregated->sum_total_marketer_commission,
            'paid_commissions' => $paid_commissions,
            'orders_cost' => $orders_cost,
            'expenses' => $expenses
        ];

        return $data;
    }
}
