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
                                    {{-- @foreach ($statuses as $status)
                                        <option  value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4" style="display: none;" id="shipping_company_select">
                            <div class="col-md-12">
                                <label class="form-label">شركة الشحن</label>
                                <select id="shipping_company_id" name="shipping_company_id" style="width: 100%">
                                    <option value="">اختار شركة الشحن</option>
                                    {{-- @foreach ($shipping_companies as $shipping_company)
                                        <option  value="{{ $shipping_company->id }}">{{ $shipping_company->name }}</option>
                                    @endforeach --}}
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

            <div class="col-12 mt-5 mb-4">
                <button class="btn btn-primary">إضافة جهاز</button>
            </div>

            <div class="col-12 mb-4">
                <div class="card shadow-sm p-3">
                    <div class="d-flex justify-content-between my-2">
                        <h3>الأجهزة</h3>
                        <p class="fw-bold">رصيد نقاط الواتساب: 0 نقطة</p>
                    </div>
                    <div class="table-responsive px-0">
                        <table class="mt-3 table table-hover" id="orders" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th>الاسم</th>
                                    <th>رقم الهاتف</th>
                                    <th>كود الواتساب</th>
                                    <th>تفعيل</th>
                                    <th>الحالة</th>
                                    <th>إعادة تفعيل</th>
                                    <th>استخدام</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div dir="ltr" class="d-flex justify-content-center">
                        {{-- {!! $orders->appends($_GET)->links() !!} --}}
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card shadow-sm p-3" >
                    <form method="GET" action="" id="search">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <h3 class="text-center"> تحضير حملة واتساب </h3>
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label">اسم الحملة</label>
                                <input class="form-control" id=""
                                    value="" placeholder="اسم الحملة">
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label">محتوي الرسالة</label>
                                <textarea class="form-control" id=""
                                    value="" placeholder="محتوي الرسالة"></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label">وقت الحملة</label>
                                <input class="form-control datetimeplugin" value="" placeholder="وقت الحملة">
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label"> من </label>
                                <input type="number" class="form-control" id=""
                                    value="" placeholder="الحد الأدني 10 ثواني">
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label"> إلي </label>
                                <input type="number" class="form-control" id=""
                                    value="" placeholder="الحد الأدني 20 ثانية">
                            </div>
                        </div>
                        <div class="d-flex my-4 justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                تجهيز
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card shadow-sm p-3" >
                    <form method="GET" action="" id="search">
                        <div class="row">
                            <div class="col-12 my-4">
                                <h3 class="text-center"> بيانات الحملة </h3>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 my-4">
                <div class="card shadow-sm p-3">
                    <h3 class="text-center my-4"> جميع الأوردرات </h3>
                    <div class="table-responsive px-0">
                        <table class="mt-3 table table-hover" id="orders" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>رقم الأوردر</th>
                                    <th>رقم البوليصة</th>
                                    <th>اسم العميل</th>
                                    <th>رقم التليفون</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->waybill ?? 'لا يوجد' }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone_1 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div dir="ltr" class="d-flex justify-content-center">
                        {!! $orders->appends($_GET)->links() !!}
                    </div> --}}
                </div>
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
@endsection
