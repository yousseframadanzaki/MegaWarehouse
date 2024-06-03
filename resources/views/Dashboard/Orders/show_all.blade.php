@extends('layouts.app')

@section('content')
<style>
#loading {
      display: inline-block;
      width: 50px;
      height: 50px;
      border: 3px solid rgb(0, 0, 0);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
    }
    @keyframes spin {
      to { -webkit-transform: rotate(360deg); }
    }
    @-webkit-keyframes spin {
      to { -webkit-transform: rotate(360deg); }
    }

    label {
        font-weight: bold;
    }
</style>
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
                        <div class="row mt-4" style="display: none;" id="shipping_company_select">
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
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="form-label">ملاحظة</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary add_image">إضافة صورة</button>
                        </div>
                        <div id="images" class="mt-4">

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
                                <select id="print_id" class="form-select" name="print_id" style="width: 100%">
                                    <option selected> --اختار-- </option>
                                    <option value="1"> 1 بوليصة فى الصفحة </option>
                                    <option value="2"> 2 بوليصة فى الصفحة </option>
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
<div class="modal fade" id="content-note" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
            <div class="modal-content" style="padding:10px;max-height:600px;overflow:auto">
                <div class="modal-header">
                    <h3 class="modal-title mx-auto">ملاحظات الطلب</h3>
                </div>
                <div class="modal-body" style="min-height:150px ; overflow: auto;font-size:14px">
                    <div class="comment-main-level clearfix" style="margin-bottom:10px">
                        <div class="">
                            <div class="comment-box"
                                style="-webkit-box-shadow: none;-moz-box-shadow: none; box-shadow: none;">
                                <div class="comment-head"
                                style="border:none;background: none;padding: 0px;">
                                <textarea class=" col-md-12 form-control input-circle recordNots"
                                            placeholder="اضافة ملاحظة ..."
                                                rows="4"></textarea>
                                        <div class="col-md-6 " style="margin-top:25px">
                                        <div class="add_notes_btn" style="">
                                    </div>
                                    </div>
                                <div id="mess" style="display:none"> </div>
                            </div>
                    </div>
                </div>
                </div>
                    <div class="row">
                        <div style="border: 1px solid #ddd">
                            <h4 style="padding: 15px 10px;background: #eee;margin: 0">
                                الملاحظات السابقة</h4>
                        <div class="notes-list">
                    </div>
                </div>
            </div>
        </div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</div>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">الأوردرات</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="card shadow-sm p-3" >
                <form method="GET" action="{{route('all_orders')}}" id="search">
                    <div class="row">
                        <div class="col-12 mt-4">
                            <h3 class="text-center">البحث عن أوردرات</h3>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="form-label">رقم الأوردر</label>
                            <input class="form-control" name="order_code" id=""
                                value="{{ Request::get('order_code') }}">
                        </div>
                        <div class="col-md-4 mt-4">
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
                        <div class="col-md-4 mt-4">
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

                        <div class="col-md-4 mt-4">
                            <label class="form-label">المدينة</label>
                            <select class="form-select product_info" @if(Request::get('city_id')) src="this.trigger('change')" @endif  name="city_id"
                                id="city_id">
                                <option value="">اختار المدينة </option>
                                @foreach ($cities as $id => $name)
                                    <option @if(Request::get('city_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="form-label">المنطقة</label>
                            <select class="form-select product_info"  name="area_id"
                                id="area_id">
                                <option value="">اختار المنطقة </option>

                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
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

                        <div class="col-md-4 mt-4">
                            <label class="form-label">المسوق</label>
                            <select class="form-select product_info" name="marketer_id">
                                <option value="">اختار المسوق</option>
                                @foreach ($marketers as $marketer)
                                    <option  @if(Request::get('marketer_id') == $marketer->id) selected @endif value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="form-label">المنتج</label>
                            <select class="form-select product_info" name="product_id" id="product_id">
                                <option value="">اختار المنتج</option>
                                @foreach ($products as $id => $name)
                                    <option  @if(Request::get('product_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="form-label">المتغير</label>
                            <select class="form-select product_info" name="variant_id" id="variant_id">
                                <option value="">اختار المتغير</option>
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
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
                        <div class="col-md-4 mt-4">
                            <label class="form-label">شركة الشحن</label>
                            <select class="form-select product_info" name="shipping_company_id">
                                <option value="">اختار شركة الشحن</option>
                                @foreach ($shipping_companies as $shipping_company)
                                    <option  @if(Request::get('shipping_company_id') == $shipping_company->id) selected @endif value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="form-label">رقم البوليصة</label>
                            <input class="form-control" name="waybill" id=""
                                value="{{ Request::get('waybill') }}">
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
                                 {{$value}}
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
                    <div class="btn-group me-2" onclick="exportTableToExcel('orders', 'كل الأوردارات')">
                        <div class="btn btn-warning"> تصدير الأوردارات اكسل <i class="bi bi-file-excel-fill"></i></div>
                    </div>
                </div>

                <div class="table-responsive px-0">
            <table class="mt-3 table table-hover" id="orders" style="min-width: 1100px;">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="form-check-input" name="" id="check_all"></th>
                        <th>رقم الأوردر</th>
                        <th>رقم البوليصة</th>
                        <th>الادمن</th>
                        <th>المسوق</th>
                        <th>الحالة</th>
                        <th>اسم العميل</th>
                        <th>رقم التليفون</th>
                        <th>العنوان</th>
                        <th>المنطقة</th>
                        <th>الاجمالى</th>
                        <th>تاريخ الاضافة</th>
                        <th>ملاحظات الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><input type="checkbox" class="order_id form-check-input" value="{{$order->id}}"></td>
                            <td><a href="{{route('show_order',$order->id)}}">{{$order->order_code}}</a></td>
                            <td>{{ $order->shipping_company_id?? 'لا يوجد' }}</td>
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
                            <td class="order_notes" data-id="{{$order->id}}">
                                <span class="btn btn-primary" style="border-radius: 50px">{{ $order->order_notes->count() }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $orders->appends($_GET)->links() !!}
            </div>
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $("td[data-status]").each(function() {
                var status = $(this).data("status");
                if (status == 5) {
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

            var product_id = "{!! Request::get('product_id') !!}"
            var variant_id = "{!! Request::get('variant_id') !!}"
            if(product_id){
                $.ajax({
                    type:'GET',
                    url:`/api/product/${product_id}/variants`,
                    dataType: "text",
                }).then((response)=>{
                    data = JSON.parse(response);
                    $('#variant_id').html('<option value="">-- اختار المتغير --</option>');
                    $.each(data, function (key,value) {
                        $("#variant_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    if(variant_id){
                        $("#variant_id").val(variant_id);
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
        $("#product_id").change(function () {
            var city_id = this.value;
            $("#variant_id").html('');
            $.ajax({
                type:'GET',
                url:`/api/product/${city_id}/variants`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $('#variant_id').html('<option value="">-- اختار المتغير --</option>');
                $.each(data, function (key, value) {
                    $("#variant_id").append('<option value="' + value.id + '">' + value.name + '</option>');
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
            if(status_id == '30'){
                $("#shipping_company_select").fadeIn();
            }
        });
        function exportTableToExcel(orders, filename = '') {
            var table = document.getElementById(orders);
            var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            var wbout = XLSX.write(wb, {bookType: 'xlsx', type: 'binary'});

            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }

            var blob = new Blob([s2ab(wbout)], {type: "application/octet-stream"});
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = filename ? filename + '.xlsx' : 'export.xlsx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        $(".order_notes").click(function () {
            var order_id = $(this).attr('data-id');
            $("#content-note").modal("show");
			$(".notes-list").html("<div id='loading'></div>");
			var btn_template = `
			<div class="pull-left" style="margin-top:3px;">
				<button type="button" class="btn btn-warning"
					style="margin-top:16px"
					onclick="recordYourNotes(${order_id});">
					 إضافة ملاحظة<i class="bi bi-plus-circle"></i>
                </button>
			</div>
			`
			$(".add_notes_btn").html(btn_template);
            $.ajax({
                type:'GET',
                url:`/api/order/${order_id}/notes`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $(".notes-list").html("");
                data.forEach(note => {
                        var template = `
                            <div>
                                <div class="btn-group me-2" style="">${note.admin.name} : ${note.note}</div>
                                <div class="col-md-12" style="margin: 5px;"><span>${note.formatted_created_at}</span></div>
                                <hr class="col-md-12" style="margin: 10px; border-color: #ddd">
                            </div>
                        `;
                        $(".notes-list").append(template);
                });
            });
        });
        function recordYourNotes($id){
            id = $id;
            note = $(".recordNots").val();
            token = $("#token").val();
            $.ajax({
                type:'POST',
                url:`/api/order/${id}/add_note`,
                dataType: "text",
                data: {
                    order_id: id,
                    note: note,
                    token: token
                }
            }).then((response)=>{
                data = JSON.parse(response);
                if (data) {
                    $(".recordNots").html('');
                    show_success('تمت اضافة الملاحظة بنجاح');
                }
            });
            function show_success(message) {
                var template = `
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <strong>${message}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                `;
                $('#mess').append(template);
                $('#mess').fadeIn();
            }
        }
    </script>
@endsection
