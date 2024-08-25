@extends('layouts.app')

@section('title')
    عرض التقرير
@endsection

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_payment_reports') }}"> تقارير التوريدات </a></li>
                <li><a class="link-dark" href=""> عرض التقرير </a></li>
            </ul>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-3 shadow-sm mt-4">
                    <div class="row">
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold"> تاريخ التقرير : </label>
                            <label>{{ $payment_report->created_at }}
                            </label>
                        </div>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold">شركة الشحن: </label>
                            <label>{{ $payment_report->shipping_company->name }}</label>
                        </div>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold"> العضو المستلم : </label>
                            <label>{{ $payment_report->transaction->from_user->name }}
                            </label>
                        </div>
                        <div class="col-12">
                            <hr class="my-2">
                        </div>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold"> تم بواسطة : </label>
                            <label>{{ $payment_report->transaction->admin->name }}
                            </label>
                        </div>
                    </div>
                    @if ($payment_report->image->count() > 0 || !empty($payment_report->note))
                        <div class="row mt-3">
                            <div class="col-12">
                                <hr class="my-2">
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    @if ($payment_report->image->count() > 0)
                                        <img src="{{ $payment_report->image->path ?? 'https://via.placeholder.com/100' }}" style="height: 150px;" class="rounded" alt="Report Image">
                                    @endif
                                    @if (!empty($payment_report->note))
                                        <p class="my-3"><span class="fw-bold">ملحوظة: </span>{{ $payment_report->note }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card p-3 shadow-sm mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="first-child">
                            <div class="d-inline-block bg-warning rounded-3 py-1 px-2 mt-2" id="totalOrders">
                                <p class="m-0">عدد الأوردرات : <span class="fw-bold">{{ $payment_report->orders_qty }}</span></p>
                                <input type="hidden" name="payment_report[orders_qty]">
                            </div>
                            <div class="d-inline-block bg-warning rounded-3 py-1 px-2 mt-2 mx-3" id="totalOrdersPrice">
                                <p class="m-0">إجمالي قيمة الأوردرات : <span class="fw-bold">{{ $payment_report->total_cod }}</span></p>
                                <input type="hidden" name="payment_report[total_cod]">
                            </div>
                            <div class="d-inline-block bg-warning rounded-3 py-1 px-2 mt-2" id="totalShippingCost">
                                <p class="m-0">إجمالي تكلفة شركة الشحن : <span class="fw-bold">{{ $payment_report->total_shipping_cost }}</span></p>
                                <input type="hidden" name="payment_report[total_shipping_cost]">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-2">
                            <thead>
                                <tr>
                                    <th>رقم الأوردر</th>
                                    <th>رقم البوليصة</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الهاتف</th>
                                    <th>المنطقة</th>
                                    <th>مبلغ التحصيل</th>
                                    <th>تكلفة الشحن</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_report->orders as $order)
                                    <td><a href="{{ route('show_order', $order->id) }}" target="_blank">{{ $order->order_code }}</a></td>
                                    <td>{{ $order->waybill??'لا يوجد' }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone_1 }}</td>
                                    <td>{{ $order->city?->name }}</td>
                                    <td>{{ $order->total_after_sale }}</td>
                                    <td>{{ $order->shipping_co_cost }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $('select').select2();
</script>
@endsection
