@extends('layouts.app')

@section('title')
    تقارير التوريدات
@endsection

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_payment_reports') }}" class="link-dark">تقارير التوريدات</a></li>
            </ul>
        </div>

        <div class="card shadow-sm p-3">
            <form method="GET" action="{{ route('all_payment_reports') }}" id="search">
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">شركات الشحن</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="shipping_company_id"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار شركة الشحن</option>
                            @foreach ($shipping_companies as $shipping_company)
                                <option @if (Request::get('shipping_company_id') == $shipping_company->id) selected @endif value="{{ $shipping_company->id }}">
                                    {{ $shipping_company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ من</label>
                        <input class="form-control datetimeplugin" name="date_from" id=""
                            value="{{ Request::get('date_from') }}">

                        <div class="invalid-feedback name">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الى</label>
                        <input class="form-control datetimeplugin" name="date_to" id=""
                            value="{{ Request::get('date_to') }}">
                    </div>
                </div>

                <div class="d-flex mt-3 justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        @if($filters)
            <div class="card shadow-sm p-3 mt-2">
                <div class="d-flex justify-content-start flex-wrap">
                    @foreach ($filters as $key => $value)
                        <div class="sidebar-bg p-2 m-1" style="width: fit-content; color: white">
                            {{ __('global.' . $key) }}: {{$value}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-4 shadow-sm">
            <div class="fw-bold mb-3">
                <label>عدد النتائج : <span id="total-result">{!! $payment_reports->total() !!}</span></label>
            </div>
            <table class="table table-hover border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">شركة الشحن</th>
                        <th scope="col">عدد الأوردرات</th>
                        <th scope="col">إجمالي قيمة الأوردرات</th>
                        <th scope="col">إجمالي تكلفة شركة الشحن</th>
                        <th scope="col">تاريخ الاضافة</th>
                        <th scope="col">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment_reports as $payment_report)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{$payment_report->shipping_company->name??''}}</td>
                           <td>{{$payment_report->orders_qty}}</td>
                           <td>{{$payment_report->total_cod}}</td>
                           <td>{{$payment_report->total_shipping_cost}}</td>
                           <td>@date_format($payment_report->created_at)</td>
                           <td><a href="{{ route('show_payment_report', $payment_report->id) }}">عرض التقرير</a></td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div dir="ltr" class="d-flex justify-content-center mt-3">
            {!! $payment_reports->appends($_GET)->links() !!}
            <p class="text-center">يتم عرض {!! $payment_reports->perPage() !!} عنصر في كل صفحة</p>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('select.product_info').select2({
                padding: 'resolve',
            });
            $(".air-datepicker-global-container").attr('dir', 'ltr');
        })
    </script>
@endsection
