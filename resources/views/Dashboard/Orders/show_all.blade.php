@extends('layouts.app')

@section('title')
    {{ __('global.orders_title') }}
@endsection

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
    .loader {
        width: 45px;
        aspect-ratio: 1;
        display: flex;
        margin-right: 95%;
        color: #582b8c;
        border: 4px solid;
        box-sizing: border-box;
        border-radius: 50%;
        background:
            radial-gradient(circle 5px, currentColor 95%, #0000),
            linear-gradient(currentColor 50%, #0000 0) 50%/4px 60% no-repeat;
        animation: l1 2s infinite linear;
    }

    .loader:before {
        content: "";
        flex: 1;
        background: linear-gradient(currentColor 50%, #0000 0) 50%/4px 80% no-repeat;
        animation: inherit;
    }

    @keyframes l1 {
        100% {
            transform: rotate(1turn)
        }
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
                                <label class="form-label">@lang('global.status_id')</label>
                                <select id="status_id" name="status_id" style="width: 100%" required>
                                    <option value="">@lang('global.select_status')</option>
                                    @foreach ($statuses as $status)
                                        <option  value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4" style="display: none;" id="shipping_company_select">
                            <div class="col-md-12">
                                <label class="form-label">@lang('global.shipping_company_id')</label>
                                <select id="shipping_company_id" name="shipping_company_id" style="width: 100%" required>
                                    <option value="">@lang('global.select_shipping_company')</option>
                                    @foreach ($shipping_companies as $shipping_company)
                                        <option  value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="form-label">@lang('global.note')</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary add_image">@lang('global.add_image')</button>
                        </div>
                        <div id="images" class="mt-4">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary change_status">@lang('global.button_update')</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.button_close')</button>
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
                                <label class="form-label">@lang('global.way_bill_print')</label>
                                <select id="print_id" class="form-select" name="print_id" style="width: 100%" required>
                                    <option value=""> @lang('global.choose')</option>
                                    <option value="1" selected> @lang('global.way_bill_type_1')</option>
                                    <option value="2"> @lang('global.way_bill_type_2')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary print">@lang('global.button_print')</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center mb-3">@lang('global.search_orders')</h5>
                    </div>
                    <div class="col-12">
                        <textarea name="" dir="rtl" id="searchData" class="w-100 form-control" rows="10" placeholder="@lang('global.placeholder_order_search')"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('global.button_search')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="content-note" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
            <div class="modal-content" style="padding:10px;max-height:600px;overflow:auto">
                <div class="modal-header">
                    <h3 class="modal-title mx-auto">@lang('global.order_notes')</h3>
                </div>
                <div class="modal-body" style="min-height:150px ; overflow: auto;font-size:14px">
                    <div class="comment-main-level clearfix" style="margin-bottom:10px">
                        <div class="">
                            <div class="comment-box"
                                style="-webkit-box-shadow: none;-moz-box-shadow: none; box-shadow: none;">
                                <div class="comment-head"
                                style="border:none;background: none;padding: 0px;">
                                <textarea class=" col-md-12 form-control input-circle recordNots"
                                            placeholder="@lang('global.placeholder_add_note')"
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
                                @lang('global.previous_notes')</h4>
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
                <li><a href="{{ route('dashboard') }}">@lang('global.dashboard')</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">@lang('global.Orders')</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="card shadow-sm p-3" >
                <form method="GET" action="{{route('all_orders')}}" id="search">
                    <div class="row">
                        <div class="col-12 my-4">
                            <h3 class="text-center">@lang('global.search_orders')</h3>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.order_code')</label>
                            <input class="form-control" name="order_code" id=""
                                value="{{ Request::get('order_code') }}">
                        </div>
                        {{-- <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.client_id')</label>
                            <select class="form-select product_info"  name="client_id" style="padding: 0.375rem 0.75rem;">
                                <option value="">@lang('global.select_client')</option>
                                @foreach ($clients as $client)
                                    <option @if(Request::get('client_id') == $client->id) selected @endif value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback name">

                            </div>
                        </div> --}}

                        <div class="col-md-4 mt-3">
                            <label class="form-label">الأدمن</label>
                            <select class="form-select product_info"  name="admin_id" style="padding: 0.375rem 0.75rem;">
                                <option value="">اختر الأدمن</option>
                                @foreach ($admins as $id => $name)
                                    <option @if(Request::get('admin_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback name">

                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.phone_1')</label>
                            <select class="form-select product_info" id="phone-select" name="client_id" style="padding: 0.375rem 0.75rem;">
                                <option value="">@lang('global.select_phone_1')</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if(Request::get('client_id') == $client->id) selected @endif>{{ $client->phone_1 }}</option>
                                    @if (!empty($client->phone_2))
                                        <option value="{{ $client->id }}" @if(Request::get('client_id') == $client->id) selected @endif>{{ $client->phone_2 }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <div class="invalid-feedback brand_id">

                            </div>

                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.city_id')</label>
                            <select class="form-select product_info" @if(Request::get('city_id')) src="this.trigger('change')" @endif  name="city_id"
                                id="city_id">
                                <option value="">@lang('global.select_city') </option>
                                @foreach ($cities as $id => $name)
                                    <option @if(Request::get('city_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.area_id')</label>
                            <select class="form-select product_info"  name="area_id"
                                id="area_id">
                                <option value="">@lang('global.select_area')</option>

                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.status_id')</label>
                            <select class="form-select product_info js-example-basic-multiple" name="status_id" multiple="multiple">
                                <option value="">@lang('global.select_status')</option>
                                @foreach ($statuses as $status)
                                    <option @if(in_array($status->id, explode(',', Request::get('status_id', '')))) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.marketer_id')</label>
                            <select class="form-select product_info" name="marketer_id">
                                <option value="">@lang('global.select_marketer')</option>
                                @foreach ($marketers as $marketer)
                                    <option  @if(Request::get('marketer_id') == $marketer->id) selected @endif value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.product_id')</label>
                            <select class="form-select product_info" name="product_id" id="product_id">
                                <option value="">@lang('global.select_product')</option>
                                @foreach ($products as $id => $name)
                                    <option  @if(Request::get('product_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.variant_id')</label>
                            <select class="form-select product_info" name="variant_id" id="variant_id">
                                <option value="">@lang('global.select_variant')</option>
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.date_from')</label>
                            <input class="form-control datetimeplugin" name="date_from" id=""
                                value="{{ Request::get('date_from') }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.date_to')</label>
                            <input class="form-control datetimeplugin" name="date_to" id=""
                                value="{{ Request::get('date_to') }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.date_type')</label>
                            <select class="form-select product_info" name="date_type">
                                <option @if(Request::get('date_type') == 'الاوردرات') selected @endif value="الاوردرات">الاوردرات</option>
                                <option @if(Request::get('date_type') == 'الحالات') selected @endif value="الحالات">الحالات</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.shipping_company_id')</label>
                            <select class="form-select product_info" name="shipping_company_id">
                                <option value="">@lang('global.select_shipping_company')</option>
                                @foreach ($shipping_companies as $shipping_company)
                                    <option @if(Request::get('shipping_company_id') == $shipping_company->id) selected @endif value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">@lang('global.way_bill')</label>
                            <input class="form-control" name="waybill" id=""
                                value="{{ Request::get('waybill') }}">
                        </div>
                        <input type="hidden" name="page_orders_num" value="{!! $orders->perPage() !!}">
                    </div>
                    <div class="d-flex my-4 justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            @lang('global.button_search')
                        </button>
                    </div>
                </form>
            </div>

            @if($filters)
                <h5 class="my-3">
                    @lang('global.search_results_number') {!! $orders->total() !!}
                </h5>
                <div class="card shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-start">
                        @foreach ($filters as $key => $value)
                            @if ($value != '' && $value != "")
                                <div class=" sidebar-bg d-flex align-items-center 1 m-1 @if ($key == 'date_type' && !array_key_exists('date_from', $filters) && !array_key_exists('date_to', $filters)) d-none @endif" style="color: white;padding: 6px;border-radius: 6px;">
                                    {{ __('global.' . $key) }}: {{$value}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

                <div class="card p-3 mb-2 mt-2 shadow-sm d-flex flex-wrap flex-row align-items-center">
                    @can('edit_change_status','App\\Models\Order')
                    <div class="me-2 my-1">
                        <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"> @lang('global.update_status') <i class="bi bi-pencil-fill"></i></div>
                    </div>
                    @endcan
                    <div class="me-2 my-1">
                        <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#PrintModal"> @lang('global.way_bill_print') <i class="bi bi-printer-fill"></i></div>
                    </div>
                    <div class="me-2 my-1">
                        <form method="POST" action="{{route('print_labels')}}" id="print_label">
                            @csrf
                        <div class="btn btn-warning print_label"> @lang('global.label_print') <i class="bi bi-printer"></i></div>
                        </form>
                    </div>
                    <div class="me-2 my-1" onclick="exportTableToExcel('orders', 'كل الأوردارات')">
                        <div class="btn btn-warning"> @lang('global.export_orders_excel') <i class="bi bi-file-excel-fill"></i></div>
                    </div>
                    @can('whatsapp_order', ['App\\Models\WhatsappCampaign'])
                    <div class="me-2 my-1">
                        <form action="{{ route('show_campaign') }}" method="GET" id="whatsappForm" target="_blank">
                            <button type="submit" disabled class="btn btn-warning"> @lang('global.whatsapp') <i class="bi bi-whatsapp"></i></div>
                        </form>
                    </div>
                    @endcan
                </div>

                <div class="row">
                    <div class="card p-3 shadow-sm">
                        <div>
                            <button class="btn btn-primary my-2" data-bs-target="#searchModal" data-bs-toggle="modal">@lang('global.button_search_orders')</button>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between mt-3">
                            <label>عدد المحدد : <span id="selection-number">0</span></label>
                            <label>عدد النتائج : <span id="total-result">{!! $orders->total() !!}</span></label>
                        </div>
                        <form action="{{ route('all_orders') }}" method="GET" style="width: fit-content">
                            <div class="d-none" id="searchData">

                            </div>
                            <select name="page_orders_num" class="py-1 mt-4 border border-gray rounded" style="outline: none;" id="page_orders_num_select">
                                <option value="50" @if ($orders->perPage() == "50") selected @endif>50</option>
                                <option value="250" @if ($orders->perPage() == "250") selected @endif>250</option>
                                <option value="500" @if ($orders->perPage() == "500") selected @endif>500</option>
                                <option value="1000" @if ($orders->perPage() == "1000") selected @endif>1000</option>
                            </select>
                        </form>
                        <div class="table-responsive px-0">
                            <table class="mt-3 table table-hover" id="orders" style="min-width: 1100px;">
                                <thead>
                                    <tr>
                                        <th class="del_from_excel"><input type="checkbox" class="form-check-input" name="" id="check_all"></th>
                                        <th>@lang('global.order_code')</th>
                                        @if ($host != $hosts['zioot'])
                                            <th hidden>شركة الشحن</th>
                                        @endif
                                        <th>@lang('global.way_bill')</th>
                                        <th>@lang('global.admin_id')</th>
                                        <th>@lang('global.marketer_id')</th>
                                        <th>@lang('global.status_id')</th>
                                        <th>@lang('global.client_id')</th>
                                        <th>@lang('global.phone_1')</th>
                                        @if ($host != $hosts['zioot'])
                                            <th hidden>رقم الهاتف 2</th>
                                        @endif
                                        <th>@lang('global.area_id')</th>
                                        <th>@lang('global.total')</th>
                                        <th>تاريخ أخر حالة</th>
                                        <th>@lang('global.created_at')</th>
                                        <th>@lang('global.order_notes')</th>
                                        @can('delete_order', 'App\Models\Order')
                                            <th class="del_from_excel">@lang('global.actions')</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="del_from_excel"><input type="checkbox" class="order_id form-check-input" value="{{$order->id}}"></td>
                                            <td><a href="{{route('show_order',$order->id)}}">{{$order->order_code}}</a></td>
                                            @if ($host != $hosts['zioot'])
                                                <td hidden>{{ $order->shipping_company?->name }}</td>
                                            @endif
                                            <td>{{ $order->waybill?? 'لا يوجد' }}</td>
                                            <td>{{$order->admin->name}}</td>
                                            <td>
                                                @isset($order->marketer->name)
                                                    {{$order->marketer->name}}
                                                @endisset
                                            </td>
                                            <td style="background-color: {{ $order->status->color }}; color: {{ $order->status->color == '#f9fafc' ? 'black' : 'white' }};" data-status="{{$order->status->id}}">{{$order->status->name}}</td>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->phone_1}}</td>
                                            @if ($host != $hosts['zioot'])
                                                <td hidden>{{$order->phone_2}}</td>
                                            @endif
                                            <td>{{$order->city?->name}} - {{$order->area?->name}}</td>
                                            <td>{{$order->total_after_sale}}</td>
                                            <td>
                                                @php
                                                    $last_status = $order->order_status->where('id', $order->status_id)->last();
                                                @endphp
                                                @if (!empty($last_status))
                                                    @date_format($last_status->pivot->created_at)
                                                @endif
                                            </td>
                                            <td>@date_format($order->created_at)</td>
                                            <td class="order_notes" data-id="{{$order->id}}">
                                                <span class="btn btn-primary" style="border-radius: 50px">{{ $order->order_notes()->count() }}</span>
                                            </td>
                                            @can('delete_order', 'App\Models\Order')
                                                <td class="del_from_excel">
                                                    <i class="bi bi-trash text-danger delete-button" style="font-size: 20px; cursor: pointer;" data-id="{{$order->id}}" data-code="{{$order->order_code}}"></i>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div dir="ltr" class="mt-4 pagination">
                            <div class="mx-auto" style="width: fit-content;">{!! $orders->links() !!}</div>
                            <p class="text-center">يتم عرض {!! $orders->perPage() !!} عنصر في كل صفحة</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
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

            $('#phone-select').on('select2:open', function() {
                // Find the search input field inside the Select2 dropdown
                const searchInput = $('.select2-container--open .select2-search__field');

                // Attach an event listener to the search input field
                searchInput.on('input', function() {
                    let newValue = $(this).val().trim();
                    $(this).val(newValue);
                });
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
                    $('#area_id').html('<option value="">@lang("global.select_area")</option>');
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
                    $('#variant_id').html('<option value="">@lang("global.select_variant")</option>');
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
                $('#area_id').html('<option value="">@lang("global.select_area")</option>');
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
                $('#variant_id').html('<option value="">@lang("global.select_variant")</option>');
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
                alert('@lang("global.alert_status_required")');
                return;
            }
            if(ids.length < 1){
                alert('@lang("global.alert_shipping_min")');
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
                alert('@lang("global.alert_shipping_min")');
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
                alert('@lang("global.alert_shipping_min")');
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
            var table2 = table;
            $(table2).find('.del_from_excel').remove();
            console.log(table2)
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
        $(document).on('click',".order_notes",function (e) {
            var order_id = $(this).attr('data-id');
            $("#content-note").modal("show");
			$(".notes-list").html("<div id='loading'></div>");
			var btn_template = `
			<div class="pull-left" style="margin-top:3px;">
				<button type="button" class="btn btn-warning"
					style="margin-top:16px"
					onclick="recordYourNotes(${order_id});">
					 @lang("global.note_addition")<i class="bi bi-plus-circle"></i>
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
                    show_success('@lang("global.alert_note_success")');
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
        $(document).on('change', 'input[type=checkbox]', function() {
            $('#selection-number').text($('table input:not(:first):checked').length);

            if($(this).is(':checked'))
                $('#whatsappForm').append(`<input type="hidden" name="orders_ids[]" value=${ $(this).val() }>`)
            else
                $(`#whatsappForm input[value=${ $(this).val() }]`).remove();

            if ($('table input:checked').length > 0) {
                $('#whatsappForm button').removeAttr('disabled')
            } else {
                $('#whatsappForm button').attr('disabled', 'disabled')
            }
        })

        $('#searchModal button').click(function() {
            let totalOrders = $('#total-orders');
            let search_data = $('textarea#searchData').val();

            if (search_data.split("\n").length > 1000) {
                alert('لا يمكنك البحث بأكثر من 1000 عنصر.');
                return;
            }

            $('#searchModal').modal('hide');
            $('#orders tbody').html('<td colspan="13" class="text-center"><div id="loading" class="my-4"></div></td>');
            $('.pagination').hide();

            $.ajax({
                url: '/api/orders/search',
                method: 'post',
                dataType: 'json',
                data: {
                    search_data
                },
                success: function(response) {
                    data = response.data;
                    $('#orders tbody').html('');
                    $.each(data, function(key, value) {
                        let table_row = `
                            <tr>
                                <td><input type="checkbox" class="order_id form-check-input" value="${value.id}"></td>
                                <td><a href="orders/${value.id}" target="_blank">${value.order_code}</a></td>
                                <td>${value.waybill ? value.waybill : '@lang("global.not_found")'}</td>
                                <td>${value.admin.name}</td>
                                <td>
                                    ${(value.marketer == null) ? '' : value.marketer.name}
                                </td>
                                <td data-status="${value.status.id}">${value.status.name}</td>
                                <td>${value.name}</td>
                                <td>${value.phone_1}</td>
                                <td>${value.city.name} - ${value.area.name}</td>
                                <td>${value.total}</td>
                                <td>${format_date(value.status_created_at)}</td>
                                <td>${format_date(value.created_at)}</td>
                                <td class="order_notes" data-id="${value.id}">
                                    <span class="btn btn-primary" style="border-radius: 50px">${value.order_notes.length}</span>
                                </td>
                                @can('delete_order', 'App\Models\Order')
                                    <td>
                                        <i class="bi bi-trash text-danger delete-button" style="font-size: 20px; cursor: pointer;" data-id="${value.id}" data-code="${value.order_code}"></i>
                                    </td>
                                @endcan
                            </tr>
                        `;

                        $('#orders tbody').append(table_row);
                    })
                    $('#total-result').text(response.total);
                }
            })
        })

        function format_date(datee) {
            // Create a specific date
            const date = new Date(datee);

            // Extract parts of the date
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            const day = String(date.getDate()).padStart(2, '0');

            let hours = String(date.getHours()).padStart(2, '0') - 1;
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            // Determine AM or PM
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            hours = String(hours).padStart(2, '0');

            // Format the date
            const formattedDate = `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;
            return formattedDate;
        }

        $(document).on('click', '.delete-button', function() {
            order_code = $(this).attr('data-code');
            if (confirm(`@lang("global.confirm_delete_order") ( ${order_code} ) ؟`)) {
                order_id = $(this).attr('data-id');
                tr = $(this).closest('tr');
                $.ajax({
                    url: `/api/order/${order_id}/delete`,
                    method: 'POST',
                    data: {
                        order_id,
                        _token: '@csrf'
                    },
                    success: function (response) {
                        tr.remove();
                        setTimeout(() => {
                            alert('@lang("global.alert_order_deleted_success")');
                        }, 500);
                    }
                })
            }
        })

        $('#page_orders_num_select').on('change', function() {
            form = $(this).closest('form');
            searchFormNotEmptyInputs = $('#search input:not([value=""]):not([name=page_orders_num])');
            searchFormNotEmptySelects = $('#search select').filter(function() {
                return $.trim($(this).val()) !== '';
            });

            form.find('#searchData').append([searchFormNotEmptyInputs, searchFormNotEmptySelects]);
            form.submit();
        })
    </script>
@endsection
