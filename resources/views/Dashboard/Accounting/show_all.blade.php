@extends('layouts.app')
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
                <li><a class="link-dark" href="{{ route('all_transactions') }}">الحسابات</a></li>
            </ul>
        </div>


        <div class="row card shadow-sm p-3 mb-4">
            <form method="GET" action="{{route('all_transactions')}}" id="search">
                <div class="row">
                    <div class="col-12 mt-4">
                        <h3 class="text-center">البحث عن عمليات</h3>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">رقم العملية</label>
                        <input class="form-control" name="transaction_code" id=""
                            value="{{ Request::get('transaction_code') }}">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">تصنيف العملية</label>
                        <select class="form-select product_info"  name="payment_category" style="padding: 0.375rem 0.75rem;" id="payment_category">
                            <option value="">اختار التصنيف ...</option>
                            @foreach ($payment_categories as $name)
                                <option value="{{$name}}" @if(Request::get('payment_category') == $name) selected @endif>{{$name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback name">

                        </div>
                    </div>

                    <div class="col-md-4 mt-4">
                        <label  class="form-label">نوع العملية</label>
                        <select class="form-select" aria-label="Default select example" name="payment_type_id" id="payment_type_id">
                         <option value="">اختار نوع العملية ...</option>
                        </select>
                    </div>

                    <div class="col-md-4 mt-4">
                        <label class="form-label">من</label>
                        <select class="form-select product_info"  name="from_user" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار</option>
                            @foreach ($users as $id => $name)
                                <option @if(Request::get('from_user') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback name">

                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">إلي</label>
                        <select class="form-select product_info"  name="to_user" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار</option>
                            @foreach ($users as $id => $name)
                                <option @if(Request::get('to_user') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback name">

                        </div>
                    </div>

                    {{-- <div class="col-md-4 mt-4">
                        <label class="form-label">رقم الاوردر</label>
                        <input class="form-control" name="order_code" id=""
                            value="{{ Request::get('order_code') }}">
                    </div> --}}

                    <div class="col-md-4 mt-4">
                        <label class="form-label">رقم الفاتورة</label>
                        <input class="form-control" name="invoice_id" id=""
                            value="{{ Request::get('invoice_id') }}">
                    </div>

                    <div class="col-md-4 mt-4">
                        <label class="form-label">تاريخ من</label>
                        <input class="form-control datetimeplugin" name="date_from" id=""
                            value="{{ Request::get('date_from') }}">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">تاريخ الى</label>
                        <input class="form-control datetimeplugin" name="date_to" id=""
                            value="{{ Request::get('date_to') }}">
                    </div>
                </div>
                <div class="d-flex my-4 justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        @if($filters)
            <div class="card shadow-sm p-3 my-4">
                <div class="d-flex justify-content-start">
                    @foreach ($filters as $key => $value)
                        <div class=" sidebar-bg p-2 m-1" style="color: white">
                            {{__($key)}} : {{$value}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="row card p-2 shadow-sm">
            <table class="table" style="vertical-align: middle;">
                <thead>
                    <tr>
                        <th>رقم العملية</th>
                        <th>من</th>
                        <th>الى</th>
                        <th>القيمة</th>
                        <th>تكلفة الشحن</th>
                        <th>عمولة</th>
                        <th>ملاحظة</th>
                        <th>رقم الاوردر</th>
                        <th>رقم الفاتورة</th>
                        <th>نوع العملية</th>
                        <th>تاريخ الاضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->from_user->name??''}}</td>
                            <td>{{$transaction->to_user->name??''}}</td>
                            <td>{{$transaction->value}}</td>
                            <td>{{$transaction->delivery_cost}}</td>
                            <td>{{$transaction->commission}}</td>
                            <td>{{$transaction->note}}</td>
                            <td><a href="{{route('show_order', $transaction->order->id ?? '')}}" target="_blank">{{$transaction->order->order_code ?? ''}}</a></td>
                            <td><a href="{{route('show_invoice', $transaction->invoice_id ?? '')}}" target="_blank">{{$transaction->invoice_id}}</td>
                            <td>{{$transaction->payment_type->name}}</td>
                            <td>@date_format($transaction->created_at)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {{-- {!! $transactions->links() !!} --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('select').select2();

        $(window).on('load', function() {
            if ($('#payment_category').val() != '')
                get_payment_types();
        });

        $('#payment_category').on('change', get_payment_types);

        function get_payment_types() {
            category = $('#payment_category').val();
            if (category != '') {
                $.ajax({
                    url: `/api/category/${category}/payment_types`,
                    method: 'get',
                    success: function(response) {
                        $('#payment_type_id').empty();
                        $('#payment_type_id').append('<option value="">اختار نوع العملية ...</option>')
                        $.each(response, function(key, value) {
                            $('#payment_type_id').append(`<option value="${key}" ${ '{{ Request::get("payment_type_id") }}' == key ? 'selected' : '' }>${value}</option>`)
                        })
                    },
                    error: function() {

                    }
                })
            } else {
                $('#payment_type_id').empty();
                $('#payment_type_id').append('<option value="">اختار نوع العملية ...</option>')
            }
        }
    </script>
@endsection
