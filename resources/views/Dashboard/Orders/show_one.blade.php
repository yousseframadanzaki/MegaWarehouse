@extends('layouts.app')

@section('title')
    {{ __('global.show_order_title') }}
@endsection

@section('content')

<style>
    tr.current_status {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }

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
        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        to {
            -webkit-transform: rotate(360deg);
        }
    }
</style>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('change_order_status',$order->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">الحالة</label>
                            <select id="status_id" name="status_id" style="width: 100%" required>
                                <option value="">اختار الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3" style="display: none;" id="shipping_company_select" required>
                        <div class="col-md-12">
                            <label class="form-label">شركة الشحن</label>
                            <select id="shipping_company_id" name="shipping_company_id" style="width: 100%">
                                <option value="">اختار شركة الشحن</option>
                                @foreach ($shipping_companies as $shipping_company)
                                    <option @if ($order->area->shipping_company && $shipping_company->id == $order->area->shipping_company->id) selected @endif
                                    value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" style="display: none;" id="variant_inputs" required>
                        <div class="col-md-9 mt-3">
                            <label class="form-label">المتغير</label>
                        </div>
                        <div class="col-md-3 mt-3">
                            <label class="form-label">الكمية</label>
                        </div>
                        @foreach ($order->stocks->where('type', 'sell') as $stock)
                            @php
                                $product_name = ($stock->variant->name == $stock->variant->product->name) ? '' : "( {$stock->variant->product->name} )";
                            @endphp
                            <div class="col-md-9 mb-2 ps-0">
                                <input type="hidden" name="variants[{{ $loop->index }}][id]" value="{{ $stock->variant_id }}" disabled>
                                <input type="text" class="form-control" name="variants[{{ $loop->index }}][name]" value="{{ $product_name }} {{$stock->variant->name }} | ( الكمية: {{ abs($stock->quantity) }} )" readonly disabled>
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="number" class="form-control variant_quantity" name="variants[{{ $loop->index }}][new_quantity]" value="" min="0" max="{{ abs($stock->quantity) }}" required disabled>
                            </div>
                        @endforeach
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">ملاحظة</label>
                            <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary add_image">أضافة صورة</button>
                    </div>
                    <div id="images" class="mt-4">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    @foreach ($templates as $template)
                    <div class="row">
                        <div class="card template_card">
                            <span>{!! $template !!}</span>
                            <a target="_blank" class="whatsapp_anchor" href="https://api.whatsapp.com/send?text={{ str_replace('<br>', '%0a', $template) }}"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="after_sale" tabindex="-1" aria-labelledby="after_sale" aria-hidden="true" style="margin-top: -100px;">
    <div class="modal-dialog modal-dialog-centered" style="width: 300px;">
        <div class="modal-content">
            <form action="{{route('change_after_sale',$order->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">اجمالى الأوردر بعد الخصم</label>
                            <input type="number" class="form-control @error('delivery_cost') is-invalid @enderror" id="delivery_cost" name="total_after_sale" value="{{ $order->total_after_sale }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('show_order',$order->id) }}">{{$order->order_code}} </a></li>
        </ul>
        <div id="message" style="display: none"></div>
        <div class="card p-3 shadow-sm mt-3">
            <div class="row">
                <h3 class="mb-4">بيانات العميل</h3>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">اسم العميل :</label>
                    <label>{{$order->name}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">رقم التليفون :</label>
                    <label>{{$order->phone_1}} @can('send_whatsapp','App\Models\Template') <i data-phone="{{$order->phone_1}}" data-bs-toggle="modal" data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;" class="bi bi-whatsapp"></i> @endcan</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> رقم تليفون اخر :</label>
                    <label>
                        @isset($order->phone_2)
                        {{$order->phone_2}}@can('send_whatsapp','App\Models\Template') <i data-phone="{{$order->phone_2}}" data-bs-toggle="modal" data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;" class="bi bi-whatsapp">@endcan</i>
                        @endisset
                    </label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">العنوان :</label>
                    <label>{{$order->address}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">المدينة :</label>
                    <label>{{$order->city->name}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">المنطقة :</label>
                    <label>{{$order->area->name}}</label>
                </div>
            </div>
            <div class="row mt-5">
                <h3 class="mb-4">بيانات الاوردر</h3>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> الادمن :</label>
                    <label>{{$order->admin->name}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">رقم الاوردر :</label>
                    <label>{{$order->order_code}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">تاريخ الاضافة :</label>
                    <label>@date_format($order->created_at)</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold">سعر الشحن :</label>
                    <label>{{$order->delivery_cost}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> الاجمالى :</label>
                    <label>{{$order->total}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> الخصم :</label>
                    <label style="color: #f32d2d;"><b>{{$order->total - $order->total_after_sale}}</b></label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> اجمالى بعد الخصم :</label>
                    <label style="color: #f32d2d;">{{$order->total_after_sale}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> حالة :</label>
                    <label class="p-1 {{ $order->status->color == '#f9fafc' ? 'text-dark' : 'text-white' }}" style="background-color: {{ $order->status->color }};">{{$order->status->name}}</label>
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> رقم البوليصة :</label>
                    <label>{{$order->waybill}}</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> شركة الشحن :</label>
                    @isset($order->shipping_company->name)
                    <label>{{$order->shipping_company->name}}</label>
                    @endisset
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> نوع العميل :</label>
                    <label>
                        @if (empty($order->order_data) || $order->order_data->client_type == 'standard')
                        standard
                        @else
                        <span class="text-primary fw-bold">{{ $order->order_data->client_type }}</span>
                        @endif
                    </label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> نوع الخدمة :</label>
                    <label>
                        @empty($order->order_data)
                        تسليم و تحصيل
                        @else
                        {{ $order->order_data->service_type }}
                        @endif
                    </label>
                </div>
            </div>
            <div class="row mt-5">
                <h3 class="mb-4">بيانات المسوق</h3>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> المسوق :</label>
                    @isset($order->marketer->name)
                    <label>{{$order->marketer->name}}</label>
                    @endisset
                </div>
                <div class="col-md-4 fs-5 mb-1">
                    <label class="fw-bold"> اجمالى عمولة المسوق :</label>
                    @isset($order->marketer->name)
                    <label>{{$order->total_marketer_commission}}</label>
                    @endisset
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-3">المنتجات</h3>
                    <table class="table table-hover" id="variants_table" style="min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>اسم المتغير</th>
                                <th>المخزن</th>
                                <th>المورد</th>
                                <th>السعر</th>
                                <th>السعر بعد الخصم</th>
                                <th>عمولة المسوق</th>
                                <th>الكمية</th>
                                <th>اجمالى العمولة</th>
                                <th>الاجمالى</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->stocks->where('type', 'sell') as $item)
                            <tr>
                                <td @empty($item->variant->name) class="text-danger" @endempty>{{$item->variant->product->name??'تابع لمتغير موجود مسبقا'}}</td>
                                <td class="@if(empty($item->variant->name)) text-danger @elseif ($item->variant->quantity < 0 && $order->status_id == 5) bg-danger text-white @endif">{{$item->variant->name??'متغير موجود مسبقا'}}</td>
                                <td>{{$item->warehouse->name}}</td>
                                <td @empty($item->variant->name) class="text-danger" @endempty>{{$item->variant->product->supplier->name??'تابع لمتغير موجود مسبقا'}}</td>
                                <td>{{$item->unit_price}}</td>
                                <td>{{$item->unit_price_after_sale}}</td>
                                <td>{{$item->unit_commission}}</td>
                                <td>{{abs($item->quantity)}}</td>
                                <td>{{abs($item->quantity) * $item->unit_commission}}</td>
                                <td>{{abs($item->quantity) * $item->unit_price_after_sale}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card p-3 my-3 shadow-sm">
            <div class="row">
                @can('edit_change_status','App\\Models\Order')
                <div class="col-sm-4 col-md-3 mb-3">
                    <div class="w-100 btn-group">
                        <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"> تعديل الحالة <i class="bi bi-pencil-fill"></i></div>
                    </div>
                </div>
                @endcan
                @can('edit_order', 'App\Models\Order')
                <div class="col-sm-4 col-md-3 mb-3">
                    <div class="w-100 btn-group edit_order_confirm" data-confirm="{{$order->status->edit_order}}">
                        <a href="{{ route('edit_order',$order->id) }}" class="btn btn-warning"> تعديل الأوردر <i class="bi bi-pencil-fill"></i></a>
                    </div>
                </div>
                @endcan
                @can('scan_orders', 'App\Models\Order')
                <div class="col-sm-4 col-md-3 mb-3">
                    <div class="w-100 btn-group">
                        <a href="{{ route('scan_order',$order->id) }}" target="_blank" class="btn btn-warning"> مراجعة الأوردر <i class="bi bi-upc-scan"></i></a>
                    </div>
                </div>
                @endcan
                <div class="col-sm-4 col-md-3 mb-3">
                    <div class="w-100 btn-group">
                        <form id="print_order_form" class="w-100" action="{{ route('print_order',$order->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="btn btn-warning print_order w-100"> طباعة بوليصة <i class="bi bi-printer-fill"></i></div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="w-100 btn-group">
                        <form id="print_label_form" class="w-100" action="{{ route('print_label',$order->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="btn btn-warning print_label w-100"> طباعة ليبل <i class="bi bi-printer"></i></div>
                        </form>
                    </div>
                </div>
                @can('add_discount', 'App\Models\Order')
                <div class="col-sm-4 col-md-3 mt-3">
                    <div class="w-100 btn-group">
                        <div class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#after_sale"> تعديل اجمالى بعد الخصم <i class="bi bi-cash-coin"></i></div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-4">
        <div class="card p-3 shadow-sm">
            <h3>الحالات</h3>
            <table class="table table-hover" id="variants_table">
                <thead>
                    <tr>
                        <th>الادمن</th>
                        <th>الحالة</th>
                        <th>ملاحظة</th>
                        <th>صور</th>
                        <th>تاريخ الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_status as $status)
                    <tr class="@if($status->pivot->current) table-primary @endif">
                        @if(isset($status->pivot->admin->name))
                        <td>{{$status->pivot->admin->name}}</td>
                        @else
                        <td>{{$order->shipping_company->name}}</td>
                        @endif
                        <td>{{$status->name}}</td>
                        <td class="truncate">{{$status->pivot->note}}</td>
                        <td>
                            @if (count($status->pivot->images) > 0)
                            <a class="link-primary" data-id="{{$status->pivot->id}}" style="cursor: pointer" data-bs-target="#imageModal" data-bs-toggle="modal"><i class="bi bi-eye"></i></a>
                            @endif
                        </td>
                        <td>@date_format($status->pivot->created_at)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="card p-3 shadow-sm">
            <div class="card">
                <div class="card-header p-0" id="headingOne">
                    <h5 class="mb-0">
                        <button data-id="{{$order->id}}" class="nav-link order_notes d-inline-block w-100 text-end px-3 py-3" data-bs-toggle="collapse" data-bs-target="#order-notes-collapse">
                            ملاحظات الطلب
                        </button>
                    </h5>
                </div>
                <div class="collapse" id="order-notes-collapse" style="">
                    <div class="card-body">
                        <div class="notes-list"></div>
                        <br>
                        <textarea class=" col-md-12 form-control input-circle recordNots" placeholder="اضافة ملاحظة ..." rows="4"></textarea>
                        <div class="my-2">
                            <input type="checkbox" name="active" id="ActiveCheck">
                            <label for="ActiveCheck" style="user-select: none;">تظهر في البوليصة</label>
                        </div>
                        <div id="mess" style="display:none"> </div>
                        <div class="add_notes_btn"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.print_order').click(function() {
        $("#print_order_form").submit();
    });
    $('.print_label').click(function() {
        $("#print_label_form").submit();
    });
    $(document).ready(function() {
        $('select').select2({
            dropdownParent: $('#statusModal')
        });
        // $('#status_id').select2({
        //     dropdownParent: $('#statusModal')
        // });
        // $('select').select2({
        //     dropdownParent: $('#statusModal')
        // });
    })
    const uid = function() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }
    $('.add_image').click(function(e) {
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
    $(document).on('change', ".image_file", function(e) {
        const [file] = e.target.files;
        if (file) {
            var template = `<img
                src='${URL.createObjectURL(file)}'
                class='image_preview'
                style="width: 100px;height:100px;object-fit:contain;"
                />`
            var id = $(this).attr('data-id');
            $("#" + id).prepend(template)
        }
    })
    $(document).on('click', ".remove_image", function(e) {
        var id = $(this).attr('data-id');
        $("#" + id).fadeOut();
        $("#" + id).remove();
    })
    $("#imageModal").on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).attr('data-id');
        $("#imageModal .modal-body").html("")
        $.ajax({
            url: `/api/status/${id}/images`,
            method: 'GET',
            dataType: 'text'
        }).then(response => {
            data = JSON.parse(response);
            if (data) {
                data.forEach(image => {
                    var template = `
                            <div class="d-flex justify-content-center mt-1">
                                <a href="/storage/${image.path}" target="_blank"><img src='/storage/${image.path}'
                                    style="width: 250px;height:250px;object-fit:contain;"
                                ></a>
                            </div>
                        `
                    $("#imageModal .modal-body").append(template);
                });
            }

        })
    })
    $('#status_id').change(function() {
        var status_id = $(this).val();
        if (status_id == '30') {
            $("#shipping_company_select").fadeIn();
        } else if (status_id == '50' || status_id == '90') {
            $("#variant_inputs").fadeIn();
            $("#variant_inputs select, #variant_inputs input").prop('disabled', false);
            if (status_id == '90') {
                $("#variant_inputs .variant_quantity").val(0);
            }
        } else {
            $("#shipping_company_select, #variant_inputs").hide();
            $("#variant_inputs select, #variant_inputs input").prop('disabled', true);
        }
    })
    $('#variant_id').change(function() {
        var quantity = $(this).val();

    })

    var whatsappModal = document.getElementById('whatsappModal');

    whatsappModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var phone = '2' + button.getAttribute('data-phone');
        $('.whatsapp_anchor').each(function(i, obj) {
            var href = new URL($(obj).attr('href'));
            href.searchParams.set('phone', phone);
            $(obj).attr('href', href.toString());
        });
    });
    $(".order_notes").click(function() {
        var order_id = $(this).attr('data-id');
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
            type: 'GET',
            url: `/api/order/${order_id}/notes`,
            dataType: "text",
        }).then((response) => {
            data = JSON.parse(response);
            $(".notes-list").html("");
            data.forEach((note, index) => {
                var template = `
                            <div>
                                <div class="col-12 fw-bold" style="font-size: 16px;">${note.admin.name}</div>
                                <div class="col-12 my-2">${note.note}</div>
                                <div class="col-12 fw-bold" style="font-size: 13px;"><span>${note.formatted_created_at}</span></div>
                                <div class="col-12 mt-3">
                                    <div class="d-inline-flex align-items-centerv border border-secondary p-1 rounded">
                                        <input type="radio" name="active" id="ActiveCheck${index}" data-id="${note.id}" ${note.active == 1 ? 'checked' : ''}>
                                        <label for="ActiveCheck${index}" style="user-select: none;" class="me-1">تظهر في البوليصة</label>
                                    </div>
                                </div>
                                <hr class="col-12" style="border-color: #333">
                            </div>
                        `;
                $(".notes-list").append(template);
            });
        });
    });

    function recordYourNotes($id) {
        id = $id;
        note = $(".recordNots").val();
        active = $('#ActiveCheck').is(':checked') ? 1 : 0;
        token = $("#token").val();
        if (note.trim() == '') {
            $('.recordNots').css('border', '1px solid red');
            $('<p class="text-danger my-2">يجب إدخال ملاحظة</p>').insertAfter($('.recordNots'));
            setTimeout(() => {
                $('.recordNots').css('border', '1px solid lightgray');
                $('.recordNots').next().remove();
            }, 5000);
            return;
        }
        $.ajax({
            type: 'POST',
            url: `/api/order/${id}/add_note`,
            dataType: "text",
            data: {
                order_id: id,
                note: note,
                active: active,
                token: token
            }
        }).then((response) => {
            data = JSON.parse(response);
            if (data) {
                $(".recordNots").html('');
                show_success('تمت اضافة الملاحظة بنجاح');
                location.reload();
            }
        });
    };

    $(document).on('change', 'input[type="radio"][name="active"]', function() {
        if (this.checked) {
            let note_id = $(this).data('id');
            $.ajax({
                url: `/api/note/${note_id}/active`,
                method: 'POST',
                data: {
                    _token: $("#token").val()
                },
                success: function(response) {
                    if (response === true) {
                        alert('تم تعديل الملاحظة بنجاح');
                    } else {
                        alert('فشل تعديل الملاحظة بنجاح');
                    }
                }
            })
        }
    })

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
    $(document).ready(function() {
        $(".edit_order_confirm a").click(function(event) {
            var $btnGroup = $(this).closest('.edit_order_confirm');
            var confirmValue = $btnGroup.data('confirm');

            if (confirmValue == 0) {
                event.preventDefault();
                show_error('عفوا لا يمنك تعديل بيانات الأوردر');
                $(window).scrollTop(0);
            }
        });
    });

    function show_error(message) {
        var template = `
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
        $('#message').append(template);
        $('#message').fadeIn();
    }
</script>
@endsection
