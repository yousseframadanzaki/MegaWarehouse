@extends('layouts.app')

@section('title')
    تقرير الأرباح
@endsection

@section('content')

<style>
    .card {
        height: 165px !important;
    }

    .bg-green {
        background-color: rgb(212, 238, 212);
    }

    .bg-red {
        background-color: rgb(228, 207, 207);
    }
</style>

<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_transactions') }}">الحسابات</a></li>
            <li><a class="link-dark" href="">تقرير الأرباح</a></li>
        </ul>
    </div>

    <div class="row mt-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-green">
                <div>
                    <h4 class="mb-3">المبيعات</h4>
                    <p>إجمالي قيمة المبيعات: <strong>{{ $data['sum_total_after_sale'] }}</strong></p>
                    <p>عدد الأوردرات المسلمة (ناجح - جزئي - استبدال): <strong>{{ $data['total_orders'] }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-red">
                <div>
                    <h4 class="mb-3">التكاليف</h4>
                    <p>إجمالي تكاليف الأوردرات: <strong>{{ $data['orders_cost'] }}</strong></p>
                    <p>إجمالي تكاليف الشحن: <strong>{{ $data['sum_shipping_co_cost'] }}</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-red">
                <div>
                    <h4 class="mb-3">العمولات</h4>
                    <p>إجمالي عمولات المسوقين: <strong>{{ $data['sum_total_marketer_commission'] }}</strong></p>
                    <p>عمولات المسوقين المدفوعة: <strong>{{ $data['paid_commissions'] }}</strong></p>
                    <p>عمولات المسوقين المتبقية: <strong>{{ $data['sum_total_marketer_commission'] - $data['paid_commissions'] }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-red">
                <div>
                    <h4 class="mb-3">المصروفات</h4>
                    <p>المصروفات: <strong>{{ $data['expenses'] }}</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <hr>
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-green">
                <div>
                    <h4 class="mb-3">الأرباح</h4>
                    <p> الأرباح: <strong>{{ $data['sum_total_after_sale'] - $data['orders_cost'] - $data['sum_total_marketer_commission'] - $data['expenses'] }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card p-3 shadow-sm bg-green">
                <div>
                    <h4 class="mb-3">المتوسطات</h4>
                    <p>متوسط سعر الأوردر: <strong>{{ round($data['sum_total_after_sale'] / (($data['total_orders']) ? $data['total_orders'] : 1)) }}</strong></p>
                    <p>متوسط تكلفة شحن الأوردر: <strong>{{ round($data['sum_shipping_co_cost'] / (($data['total_orders']) ? $data['total_orders'] : 1)) }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
