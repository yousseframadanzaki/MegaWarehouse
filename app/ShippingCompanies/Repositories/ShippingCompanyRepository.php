<?php

namespace App\ShippingCompanies\Repositories;

use App\Models\ShippingCompany;
use App\Models\Order;
use App\Models\Transaction;
use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;

class ShippingCompanyRepository implements ShippingCompanyRepositoryInterface{

    public function create_shipping_company($data){
        return ShippingCompany::create($data);
    }

    public function get_shipping_companies_by_company_id($company_id){
        return ShippingCompany::with('shipping_areas')->where(['company_id'=>$company_id])->get();
    }
    public function get_shipping_company_by_id($id){
        return ShippingCompany::with('orders', 'orders.status')->findOrFail($id);
    }
    public function update_shipping_company_by_id($id,$data){
        return ShippingCompany::where(['id'=>$id])->update($data);
    }

    public function get_shipping_company_calculations($shipping_company_id, $orders_filters, $request) {
        $company_id = auth()->user()->company_id;
        $shipping_user_id = ShippingCompany::findOrFail($shipping_company_id)->user_id;

        $query = Order::where([
            'company_id' => $company_id
        ])->whereHas('order_status', function($query) {
            $query->where('statuses.id', 33);
        })->filter($orders_filters);

        // Get paginated orders
        $paginated_orders = $query->paginate(50)->appends($request);

        // Get total orders count
        $orders = $query->selectRaw('COALESCE(SUM(shipping_co_cost), 0) AS total_shipping_co_cost, COUNT(id) AS total_orders')->first();

        // Get success orders count
        $success_orders = $query->whereHas('order_status', function($query) {
                $query->whereIn('statuses.id', [45, 50, 55]);
            })
            ->count();

        // Get the sum of total_after_sale for specific statuses
        $total_after_sale = $query->whereHas('order_status', function($query) {
                $query->whereIn('statuses.id', [45, 50, 55, 75]);
            })
            ->sum('total_after_sale');

        $sum_transactions_to_shipping = Transaction::where([
            'company_id' => $company_id,
            'to' => $shipping_user_id
        ])->sum('value');

        $data = [
            'orders' => $paginated_orders,
            'total_orders' => $orders->total_orders,
            'success_orders' => $success_orders,
            'total_after_sale' => $total_after_sale,
            'total_shipping_co_cost' => $orders->total_shipping_co_cost,
            'sum_transactions_to_shipping' => $sum_transactions_to_shipping
        ];

        return $data;
    }

}
