<?php

namespace App\PaymentReports\Repositories;

use App\Models\PaymentReport;
use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;

class PaymentReportRepository implements PaymentReportRepositoryInterface {
    public function get_company_orders($company_id,$filters,$request){
        $number = !empty($request['page_orders_num']) ? $request['page_orders_num'] : 50;
        $query = Order::with(['marketer','admin','status','city','area','order_notes', 'order_data', 'order_status'])->where(['company_id'=>$company_id])->filter($filters)->orderBy('created_at','DESC');
        if (empty($request['no_paginate'])) {
            return $query->paginate($number)->appends($request);
        } else {
            return $query->get();
        }
    }

    public function get_payment_reports($filters, $request) {
        $number = !empty($request['page_orders_num']) ? $request['page_orders_num'] : 50;
        return PaymentReport::with(['shipping_company'])->filter($filters)->orderBy('created_at', 'DESC')->paginate($number)->appends($request);
    }

    public function create_payment_report($data) {
        return PaymentReport::create($data);
    }

    public function get_payment_report_by_id($id) {
        return PaymentReport::find($id);
    }

    public function get_payment_report_by_shipping_company_id($shipping_company_id) {
        return PaymentReport::where('shipping_company_id', $shipping_company_id)->get();
    }
}
