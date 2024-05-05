@extends('layouts.app')

@section('content')

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('change_order_status_bulk')}}" method="POST" enctype="multipart/form-data" id="change_status_form">
                @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">الحالة</label>
                                <select id="status_id" name="status_id" style="width: 100%">
                                    <option value="">اختار الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option  value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2" style="display: none;" id="shipping_company_select">
                            <div class="col-md-12">
                                <label class="form-label">شركة الشحن</label>
                                <select id="shipping_company_id" name="shipping_company_id" style="width: 100%">
                                    <option value="">اختار شركة الشحن</option>
                                    @foreach ($shipping_companies as $shipping_company)
                                        <option  value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="form-label">ملاحظة</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary add_image">أضافة صورة</button>
                        </div>
                        <div id="images" class="mt-2">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary change_status">تعديل</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="PrintModal" tabindex="-1" aria-labelledby="PrintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('print_orders')}}" method="POST" enctype="multipart/form-data" id="print_form">
                @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">طباعة بوليصة</label>
                                <select id="print_id" name="print_id" style="width: 100%">
                                    <option selected> --اختار-- </option>
                                    <option value="1"> 1 بوليصة فى الصفحة </option>
                                    <option value="2"> 5 بوليصة فى الصفحة </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary print">طباعة</button>
                    </div>
            </form>
        </div>
    </div>
</div>

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
                            <select class="form-select product_info js-example-basic-multiple" name="status_id" multiple="multiple">
                                <option value="">اختار الحالة</option>
                                @foreach ($statuses as $status)
                                    <option @if(in_array($status->id, explode(',', Request::get('status_id', '')))) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">المسوق</label>
                            <select class="form-select product_info" name="marketer_id">
                                <option value="">اختار الحالة</option>
                                @foreach ($marketers as $marketer)
                                    <option  @if(Request::get('marketer_id') == $marketer->id) selected @endif value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">شركة الشحن</label>
                            <select class="form-select product_info" name="shipping_company_id">
                                <option value="">اختار شركة الشحن</option>
                                @foreach ($shipping_companies as $shipping_company)
                                    <option  @if(Request::get('shipping_company_id') == $shipping_company->id) selected @endif value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">رقم البوليصة</label>
                            <input class="form-control" name="waybill" id=""
                                value="{{ Request::get('waybill') }}">
                        </div>
                    </div>
                    <div class="d-flex mt-3 justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            بحث
                        </button>
                    </div>
                </form>
            </div>

            @if($filters)
                <div class="card shadow-sm p-3 mt-2">
                    <div class="d-flex justify-content-start">
                        @foreach ($filters as $key => $value)
                            <div class=" sidebar-bg p-2 m-1" style="color: white">
                                {{__($key)}}: {{$value}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

                <div class="card p-3 mb-2 mt-2 shadow-sm d-flex flex-row">
                    @can('edit_change_status','App\\Models\Order')
                    <div class="btn-group me-2">
                        <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"> تعديل الحالة <i class="bi bi-pencil-fill"></i></div>
                    </div>
                    @endcan
                    <div class="btn-group me-2">
                        <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#PrintModal"> طباعة بوليصة <i class="bi bi-printer-fill"></i></div>
                    </div>
                    <div class="btn-group me-2">
                        <form method="POST" action="{{route('print_labels')}}" id="print_label">
                            @csrf
                        <div class="btn btn-warning print_label"> طباعة ليبل <i class="bi bi-printer"></i></div>
                        </form>
                    </div>
                </div>

            <table class="mt-3 table table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="form-check-input" name="" id="check_all"></th>
                        <th>رقم الاوردر</th>
                        <th>الادمن</th>
                        <th>المسوق</th>
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
                            <td><input type="checkbox" class="order_id form-check-input" value="{{$order->id}}"></td>
                            <td><a href="{{route('show_order',$order->id)}}">{{$order->order_code}}</a></td>
                            <td>{{$order->admin->name}}</td>
                            <td>
                                @isset($order->marketer->name)
                                    {{$order->marketer->name}}
                                @endisset
                            </td>
                            <td data-status="{{$order->status->id}}">{{$order->status->name}}</td>
                            <td>{{$order->name}}</td>
                            <td>{{$order->phone_1}}</td>
                            <td>{{$order->address}}</td>
                            <td>{{$order->city->name}} - {{$order->area->name}}</td>
                            <td>{{$order->total}}</td>
                            <td>@date_format($order->created_at)</td>
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
            $("td[data-status]").each(function() {
                var status = $(this).data("status");
                if (status == 18) {
                    $(this).css({"background-color": "#bb4141","color": "white"});
                }
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $(document).ready(function() {
            $('select.product_info').select2({
                padding: 'resolve',
            });
            $(".air-datepicker-global-container").attr('dir', 'ltr');

            $('#status_id').select2({
                dropdownParent: $('#statusModal')
            });
            $('#shipping_company_id').select2({
                dropdownParent: $('#statusModal')
            });
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
                    $.each(data, function (key,value) {
                        $("#area_id").append('<option value="' + value.id + '">' + value.name + '</option>');
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
                    $("#area_id").append('<option value="' + value.id + '">' + value.name + '</option>');
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
        const uid = function() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        }
        $('.add_image').click(function (e) {
            e.preventDefault();
            var id = uid();
            var template = `
            <div id="${id}" class="d-flex flex-column align-items-center">
                <div class="input-group mb-3" dir="ltr" >
                    <button class="btn btn-danger remove_image" data-id="${id}"><i class="bi bi-trash"></i></button>
                    <input type='file' class='form-control image_file' data-id="${id}" name='status_images[]' aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                </div>
            </div>
            `
            $("#images").append(template);
        })
        $(document).on('change',".image_file",function (e) {
            const [file] = e.target.files;
            if(file){
                var template = `<img
                src='${URL.createObjectURL(file)}'
                class='image_preview'
                style="width: 100px;height:100px;object-fit:contain;"
                />`
                var id= $(this).attr('data-id');
                $("#"+id).prepend(template)
            }
        })
        $(document).on('click',".remove_image",function (e) {
            var id = $(this).attr('data-id');
            $("#"+id).fadeOut();
            $("#"+id).remove();
        })
        $("#check_all").click(function () {
            $('.order_id').click();
        })
        function get_checked_orders() {
            ids = [];
            $('.order_id').each(function (index, obj) {
                if (this.checked === true) {
                    ids.push(this.value);
                }
            });
            return ids;
        }

        $('.change_status').click(function (e) {
            e.preventDefault();
            var ids = get_checked_orders();
            var status_id = $('#status_id').val();
            console.log(ids);
            if(!status_id){
                alert('برجاء اختيار الحالة');
                return;
            }
            if(ids.length < 1){
                alert('برجاء اختيار شحنة واحدة على الاقل');
                return;
            }

            ids.forEach(id => {
                $("#change_status_form").append(`<input type="hidden" name="orders_ids[]" value="${id}" />`);
            });

            $("#change_status_form").submit();
        })
        $('.print').click(function (e) {
            e.preventDefault();
            var ids = get_checked_orders();
            var selectedValue = $('#print_id').val();

            if(ids.length < 1){
                alert('برجاء اختيار شحنة واحدة على الاقل');
                return;
            }

            ids.forEach(id => {
                $("#print_form").append(`<input type="hidden" name="orders_ids[]" value="${id}" />`);
                $("#print_form").append(`<input type="hidden" name="selected_option" value="${selectedValue}" />`);
            });
            $("#print_form").submit();
        })
        $('.print_label').click(function(e){
            e.preventDefault();
            var ids = get_checked_orders();
            var selectedValue = '1';
            var OneValue = '2';

            if(ids.length < 1){
                alert('برجاء اختيار شحنة واحدة على الاقل');
                return;
            }
            if(ids.length == 1) {
                ids.forEach(id => {
                    $("#print_label").append(`<input type="hidden" name="orders_labels_ids[]" value="${id}" />`);
                });
                $("#print_label").append(`<input type="hidden" name="selected_option" value="${selectedValue}" />`);
            }
            if(ids.length > 1) {
                ids.forEach(id => {
                    $("#print_label").append(`<input type="hidden" name="orders_labels_ids[]" value="${id}" />`);
                });
                $("#print_label").append(`<input type="hidden" name="selected_option" value="${OneValue}" />`);
            }
            $("#print_label").submit();
        });
        $('#status_id').change(function () {
            var status_id = $(this).val();
            if(status_id == '5'){
                $("#shipping_company_select").fadeIn();
            }
        })
    </script>
@endsection
