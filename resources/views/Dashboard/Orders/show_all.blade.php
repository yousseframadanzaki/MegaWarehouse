@extends('layouts.app')

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">الاوردرات</a></li>
            </ul>
        </div>
    <div class="row">
        <div class="card shadow-sm p-3" >
            <form method="GET" action="{{route('all_orders')}}" id="search">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">رقم الاوردر</label>
                        <input class="form-control" name="order_code" id=""
                            value="{{ Request::get('order_code') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العميل</label>
                        <select class="form-select product_info"  name="client_id" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار العميل</option>
                            @foreach ($clients as $client)
                                <option @if(Request::get('client_id') == $client->id) selected @endif value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback name">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون</label>
                        <select class="form-select product_info"  name="client_id" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار رقم التليفون</option>
                            @foreach ($clients as $client)
                                <option  value="{{ $client->id }}">{{ $client->phone_1 }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback brand_id">

                        </div>

                    </div>
                    
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">المدينة</label>
                        <select class="form-select product_info" @if(Request::get('city_id')) src="this.trigger('change')" @endif  name="city_id"
                            id="city_id">
                            <option value="">اختار المدينة </option>
                            @foreach ($cities as $id => $name)
                                <option @if(Request::get('city_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المنطقة</label>
                        <select class="form-select product_info"  name="area_id"
                            id="area_id">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحالة</label>
                        <select class="form-select product_info" name="status_id">
                            <option value="">اختار الحالة</option>
                            @foreach ($statuses as $status)
                                <option  @if(Request::get('status_id') == $status->id) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback supplier_id">

                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">تاريخ من</label>
                        <input class="form-control datetimeplugin" name="date_from" id=""
                            value="{{ Request::get('date_from') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الى</label>
                        <input class="form-control datetimeplugin" name="date_to" id=""
                            value="{{ Request::get('date_to') }}">
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        <table class="mt-3 table table-hover">
            <thead>
                <tr>
                    <th>رقم الاوردر</th>
                    <th>الادمن</th>
                    <th>الحالة</th>
                    <th>اسم العميل</th>
                    <th>رقم التليفون</th>
                    <th>العنوان</th>
                    <th>المنطقة</th>
                    <th>الاجمالى</th>
                    <th>تاريخ الاضافة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{route('show_order',$order->id)}}">{{$order->order_code}}</a></td>
                        <td>{{$order->admin->name}}</td>
                        <td>{{$order->status->name}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->phone_1}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->city->name}} - {{$order->area->name}}</td>
                        <td>{{$order->total}}</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div dir="ltr" class="d-flex justify-content-center">
            {!! $orders->appends($_GET)->links() !!}
        </div>
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

            var city_id = "{!! Request::get('city_id') !!}"
            var area_id = "{!! Request::get('area_id') !!}"
            if(city_id){
                $.ajax({
                    type:'GET',
                    url:`/api/city/${city_id}/areas`,
                    dataType: "text",
                }).then((response)=>{
                    data = JSON.parse(response);
                    $('#area_id').html('<option value="">-- اختار المنطقة --</option>');
                    $.each(data, function (key, value) {
                        $("#area_id").append('<option value="' + key + '">' + value + '</option>');
                    });
                    if(area_id){
                        $("#area_id").val(area_id);
                    }
                })
            }
        })
        $("#city_id").change(function () {
            var city_id = this.value;
            $("#area_id").html('');
            $.ajax({
                type:'GET',
                url:`/api/city/${city_id}/areas`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $('#area_id').html('<option value="">-- اختار المنطقة --</option>');
                $.each(data, function (key, value) {
                    $("#area_id").append('<option value="' + key + '">' + value + '</option>');
                });
            })
        })
        $("#search").submit(function (e) {
            e.preventDefault();
            const query = {};
            $("#search input, #search select").each(function () {
                if($(this).val()){
                    query[$(this).attr('name')] = $(this).val();
                }
            })
            let params = new URLSearchParams(query);
            window.location.search = params.toString();
        })
    </script>
@endsection