@extends('layouts.app')

@section('title')
    {{ __('add_whatsapp_points_title') }}
@endsection

@section('content')
<style>
.loader {
        width: 45px;
        aspect-ratio: 1;
        display: flex;
        margin-right: 40%;
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
                <div id="message" style="display:none;"></div>
                    <div class="loader" style="display: none"></div>
                    <img id="whatsapp_qrCode" src='' width='310' title="فحص" />
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
                                            <h5><span class="text-success active_word">مفعل</span></h5>
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
        function show_qr_code(instance_id) {
            var instance_id = instance_id;
            $('.loader').show();
            $('#whatsapp_qrCode').hide();
            $.ajax({
                type: 'get',
                url: `/api/campaign/get_qr_code/${instance_id}`,
                dataType: "json",
            }).then((response) => {
                data = JSON.parse(response);
                    if (data['status'] == 'success') {
                        $('.loader').hide();
                        $('#whatsapp_qrCode').show();
                        document.getElementById("whatsapp_qrCode").src = data['base64'];
                    }
                    if (data['status'] == 'error' && data['message'] ==
                        'instance id has been used') {
                        show_error('هذا الرقم مفعل بالفعل!');
                    }
            });
        };
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
