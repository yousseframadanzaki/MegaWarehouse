@extends('layouts.app')

@section('title')
    حسابات شركات الشحن
@endsection

@section('content')
    <style>
        label {
            font-weight: bold;
        }
    </style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('shipping_company_calculations') }}">حسابات شركات الشحن</a></li>
            </ul>
        </div>
        <div class="row mt-4">
            <div class="col-12 mx-auto">
                <div class="card shadow-sm p-3">
                    <form method="GET" action="{{ route('shipping_company_calculations') }}">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 col-lg-2">
                                <label class="form-label">شركة الشحن</label>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9">
                                <select class="form-select product_info"  name="shipping_company_id" id="shipping_company_id" style="padding: 0.375rem 0.75rem;" required>
                                    <option value="">اختار شركة الشحن</option>
                                    @foreach ($shipping_companies as $shipping_company2)
                                        <option value="{{ $shipping_company2->id }}" @if(!empty($shipping_company->id) && $shipping_company->id == $shipping_company2->id) selected @endif>{{ $shipping_company2->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-md-none mt-2"></div>
                            <div class="col-12 col-md-2 col-lg-1">
                                <button type="submit" class="btn btn-primary">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (!empty($shipping_company))
                <div class="col-12">
                    <div class="card p-3 shadow-sm mt-4">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center fw-bold">{{ $shipping_company->name }}</h1>
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <div class="card text-center text-white py-2 btn-primary">
                                    <h6>الرصيد الحالي</h6>
                                    <p class="mb-0">---</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <div class="card text-center text-white py-2 btn-primary">
                                    <h6>أوردرات قيد الشحن</h6>
                                    <p class="mb-0">{{ $shipping_company->orders->where('status.related_shipping', 1)->count() }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <div class="card text-center text-white py-2 btn-primary">
                                    <h6>مرتجعات لم تصل</h6>
                                    <p class="mb-0">{{ $shipping_company->orders->where('status_id', 70)->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <form action="" dir="rtl">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="text-center fw-bold">البحث عن الاوردرات</h4>
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label class="form-label">@lang('global.date_from')</label>
                                            <input class="form-control datetimeplugin" name="date_from" id=""
                                                value="{{ Request::get('date_from') }}">
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label class="form-label">@lang('global.date_to')</label>
                                            <input class="form-control datetimeplugin" name="date_to" id=""
                                                value="{{ Request::get('date_to') }}">
                                        </div>
                                        <input type="hidden" name="shipping_company_id" value="{{ $shipping_company->id }}">
                                        <div class="col-md-2 d-flex flex-column justify-content-end mt-3">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">بحث</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>عدد الأوردرات</th>
                                                <th>تسليم ناجح</th>
                                                <th>إجمالي المحصل</th>
                                                <th>إجمالي تكلفة الشحن</th>
                                                <th>نسبة التسليم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_orders = $filteredOrders->count();
                                                $success_orders = $filteredOrders->where('status_id', 45)->count();
                                            @endphp
                                            <tr>
                                                <td>{{ $total_orders }}</td>
                                                <td>{{ $success_orders }}</td>
                                                <td>{{ $filteredOrders->sum('total_after_sale') }}</td>
                                                <td>{{ $filteredOrders->sum('shipping_co_cost') }}</td>
                                                <td>{{ number_format($success_orders / (($total_orders > 0) ? $total_orders : 1) * 100, 2, '.', '') }} %</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الأوردر</th>
                                                <th>رقم البوليصة</th>
                                                <th>اسم العميل</th>
                                                <th>المنطقة</th>
                                                <th>الحالة النهائية</th>
                                                <th>الحالة الحالية</th>
                                                <th>مبلغ التحصيل</th>
                                                <th>تكلفة الشحن</th>
                                                <th>تاريخ التوريد</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($filteredOrders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{ route('show_order', ['order_id' => $order->id]) }}">{{ $order->order_code }}</a></td>
                                                    <td>{{ $order->waybill??'لا يوجد' }}</td>
                                                    <td>{{ $order->client->name }}</td>
                                                    <td>{{ $order->area->name }}</td>
                                                    <td></td>
                                                    <td style="background-color: {{ $order->status->color }}; color: {{ $order->status->color == '#f9fafc' ? 'black' : 'white' }};">{{ $order->status->name }}</td>
                                                    <td>{{ $order->total_after_sale }}</td>
                                                    <td>{{ $order->shipping_co_cost }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {!! $filteredOrders->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $('select').select2();
    </script>
@endsection
