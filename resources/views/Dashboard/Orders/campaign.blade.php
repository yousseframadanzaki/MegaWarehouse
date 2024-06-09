@extends('layouts.app')

@section('title')
    {{ __('add_whatsapp_points_title') }}
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

    label {
        font-weight: bold;
    }
</style>
<div class="modal fade" id="AddDeviceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content" style="padding:10px;max-height:600px;width: 400px;">
            <form action="{{ route('add_whatsapp_device') }}" method="POST">
                @csrf
            <div class="modal-header">
                <h3 class="modal-title mx-auto">إضافة جهاز</h3>
            </div>
            <div class="modal-body d-flex justify-content-center" style="min-height:150px;font-size:14px;">
                <div class="comment-main-level clearfix" style="margin-bottom:10px; width: 100%;">
                    <div class="d-flex flex-column align-items-center w-100">
                        <div class="col-md-10 mb-3">
                            <label class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="col-md-10">
                            <label class="form-label">رقم التليفون</label>
                            <input type="number" class="form-control" name="phone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center w-100">
                <button type="submit" class="btn btn-primary">إضافة جهاز</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade hidden-print" id="ActivatePhone" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 350px;">
        <div class="modal-content" style="padding:10px;max-height:600px;overflow:auto">
            <div class="modal-body text-center">
                <h3 style="color: #5b9bd1;">برجاء مسح ال qr code</h3>
                <form method='post'>
                    <img id="whatsapp_qrCode" src='' width='310' title="فحص" />
                </form>
                <button type="button" id="close_modal" class="btn btn-danger">
                    <i class="fa fa-xmark"></i>
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">الأوردرات</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="d-flex justify-content-between my-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddDeviceModal">إضافة جهاز</button>
                    <p data-expire="{{ $user_points->expire_date }}" class="fw-bold">
                        رصيد نقاط الواتساب: {{ $user_points->points }} نقطة
                    </p>
            </div>
            <div class="col-12 mb-4">
                <div class="card shadow-sm p-3">
                    <div class="d-flex justify-content-between my-2">
                        <h3>الأجهزة</h3>
                        <span>تاريخ الانتهاء: {{ date('Y-m-d h:i:s A', strtotime($user_points->expire_date)) }}</span>
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
                                @foreach ($devices as $device)
                                <tr>
                                    <td class="fw-bold">#{{ $device->id }}</td>
                                    <td>{{ $device->name }}</td>
                                    <td>0{{ $device->phone }}</td>
                                    <td>{{ $device->instance_id }}</td>
                                    <td>
                                        @if ($device->active != '1')
                                            <a href="#" id="actv" data-instance="{{ $device->instance_id }}" data-bs-toggle="modal"
                                                data-bs-target="#ActivatePhone" class="btn btn-primary" onclick="show_qr_code('{{ $device->instance_id }}')">
                                                تفعيل الرقم <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif 
                                    </td>
                                    <td>
                                        @if ($device->active == '1')
                                            <h5><span class="text-success">مفعل</span></h5>
                                        @else
                                            <h5><span class="text-danger">غير مفعل</span></h5>
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-bold">حذف <i class="text-danger bi bi-trash"></i></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                </div>
            </div>
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $("#submitButton").click(function(ev) {
            var form = $("#new_device_form");
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {

                    // Ajax call completed successfully
                    msg = JSON.parse(data);

                    document.getElementById("alert_message").style.display = "block";
                    document.getElementById("alert_message").classList.add(msg['type']);
                    document.getElementById("alert_message").innerHTML = msg['message'];

                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                },
                error: function(data) {
                    // Some error in ajax call
                    alert("some Error");
                }
            });
        });
        function show_qr_code(instance_id) {
            var instance_id = instance_id;
            $.ajax({
                type: 'GET',
                url: `/api/campaign/get_qr_code/${instance_id}`,
                dataType: "json",
            }).then((data) => {
                $('#whatsapp_qrCode').attr('src', data);
            })
        };
</script>
@endsection
