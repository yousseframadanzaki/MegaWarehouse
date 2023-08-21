@extends('layouts.app')

@section('content')



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
                        <button type="submit" class="btn btn-primary">تعديل</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<style>
    tr.current_status{
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
</style>
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('show_order',$order->id) }}">{{$order->order_code}} </a></li>
        </ul>

        <div class="card p-3 shadow-sm mt-3">
            <div class="row">
                <h3>بيانات العميل</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">اسم العميل :</label>
                    <label>{{$order->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم التليفون :</label>
                    <label>{{$order->phone_1}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> رقم تليفون اخر :</label>
                    <label>{{$order->phone_2}}</label>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">العنوان :</label>
                    <label>{{$order->address}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">المدينة :</label>
                    <label>{{$order->city->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">المنطقة :</label>
                    <label>{{$order->area->name}}</label>
                </div>
            </div>
            <div class="row mt-4">
                <h3>بيانات الاوردر</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم الاوردر :</label>
                    <label>{{$order->order_code}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">تاريخ الاضافة :</label>
                    <label>@date_format($order->created_at)</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> الاجمالى :</label>
                    <label>{{$order->total}}</label>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> الادمن :</label>
                    <label>{{$order->admin->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> حالة :</label>
                    <label>{{$order->status->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> رقم البوليصة :</label>
                    <label>{{$order->waybill}}</label>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> شركة الشحن :</label>
                    @isset($order->shipping_company->name)
                    <label>{{$order->shipping_company->name}}</label>
                    @endisset
                </div>
                
            </div>
            <div class="row mt-4">
                <h3>بيانات المسوق</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> المسوق :</label>
                    @isset($order->marketer->name)
                        <label>{{$order->marketer->name}}</label>
                    @endisset
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> اجمالى عمولة المسوق :</label>
                    @isset($order->marketer->name)
                        <label>{{$order->total_marketer_commission}}</label>
                    @endisset
                </div>
            </div>
            <div class="row mt-4">
                <h3>المنتجات</h3>
                <table class="table table-hover" id="variants_table">
                    <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>اسم المتغير</th>
                            <th>المخزن</th>
                            <th>السعر</th>
                            <th>عمولة المسوق</th>
                            <th>الكمية</th>
                            <th>الاجمالى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->pivot->warehouse->name}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->product->marketer_commission}}</td>
                                <td>{{$item->pivot->quantity}}</td>
                                <td>{{$item->pivot->quantity * $item->price}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            </div>
            
        </div>
        @can('edit_change_status','App\\Models\Order')
        <div class="row mt-3">
            <div class="card p-3 shadow-sm d-flex flex-row">
                <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"> تعديل الحالة <i class="bi bi-pencil-fill"></i></div>
            </div>
        </div>
        @endcan
        <div class="row mt-3">
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

    </div>
</div>

@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#status_id').select2({
                dropdownParent: $('#statusModal')
            });
            $('#shipping_company_id').select2({
                dropdownParent: $('#statusModal')
            });
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
        $("#imageModal").on('show.bs.modal',function (e) {
            var id = $(e.relatedTarget).attr('data-id');
            $("#imageModal .modal-body").html("")
            $.ajax({
                url:`/api/status/${id}/images`,
                method:'GET',
                dataType:'text'
            }).then(response =>{
                data = JSON.parse(response);
                if(data){
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
        $('#status_id').change(function () {
            var status_id = $(this).val();
            if(status_id == '5'){
                $("#shipping_company_select").fadeIn();
            }
        })
    </script>
@endsection