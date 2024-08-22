@extends('layouts.app')

@section('title')
    إضافة تقرير توريد
@endsection

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a> تقارير توريدات شركة الشحن </a></li>
                <li><a class="link-dark" href=""> إضافة تقرير </a></li>
            </ul>
        </div>
        <form method="POST" action="{{ route('store_shipping_company_report') }}">
            @csrf
            <div class="row mt-4">
                <div class="col-12 mx-auto">
                    <div class="card shadow-sm p-3">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">شركة الشحن</label>
                                <select class="form-select product_info"  name="payment_report[shipping_company_id]" id="shipping_company_id" style="padding: 0.375rem 0.75rem;" required>
                                    <option value="">اختار شركة الشحن</option>
                                    @foreach ($shipping_companies as $shipping_company2)
                                        <option value="{{ $shipping_company2->id }}" @if(!empty($shipping_company->id) && $shipping_company->id == $shipping_company2->id) selected @endif>{{ $shipping_company2->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">الأوردرات <span class="text-secondary"> ( اختار شركة الشحن أولا ) </span></label>
                                <textarea name="order_ids" rows="1" dir="rtl" id="searchOrders" class="w-100 form-control" rows="10" placeholder="" disabled></textarea>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button type="button" class="btn btn-primary" id="checkOrders" disabled> فحص الأوردرات </button>
                                <p class="text-center text-secondary fw-bold mt-3 mb-0" id="checkLoader" style="display: none;">جاري الفحص ...</p>
                            </div>
                            <div class="mt-3" id="messageContainer" style="display: none;">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="successData" style="display: none;">
                    <div class="card p-3 shadow-sm mt-4">
                        <label class="form-label fw-bold mb-3">ملحوظة</label>
                        <textarea id="summernote" type="text" class="form-control product_info " name="">{!! old('product_info.description') !!}</textarea>
                        <div class="invalid-feedback">

                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-primary my-3 rounded" style="cursor: pointer;" id="addImage">
                                أضف صورة
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <div class="input-images" style="cursor:pointer;"></div>
                    </div>

                    <div class="card p-3 shadow-sm mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="first-child">
                                <div class="mt-2" id="totalOrders">
                                    <p class="m-0">عدد الأوردرات : <span class="fw-bold"></span></p>
                                    <input type="hidden" name="payment_report[orders_qty]">
                                </div>
                                <div class="mt-2" id="totalOrdersPrice">
                                    <p class="m-0">إجمالي الأوردرات : <span class="fw-bold"></span></p>
                                    <input type="hidden" name="payment_report[total_cod]">
                                </div>
                                <div class="mt-2 mb-4" id="totalShippingCost">
                                    <p class="m-0">إجمالي تكلفة الشحن : <span class="fw-bold"></span></p>
                                    <input type="hidden" name="payment_report[total_shipping_cost]">
                                </div>
                            </div>
                            <div class="second-child">
                                <button type="submit" class="btn btn-primary">عمل تقرير</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>رقم الأوردر</th>
                                        <th>رقم البوليصة</th>
                                        <th>اسم العميل</th>
                                        <th>رقم الهاتف</th>
                                        <th>المنطقة</th>
                                        <th>مبلغ التحصيل</th>
                                        <th>تكلفة الشحن</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" src="{{url('/static/js/image-uploader.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#addImage').on('click', function() {
            $('.image-uploader input').click();
        })
        $('.input-images').imageUploader();
    })
</script>
<script>
    $('select').select2();

    $('#shipping_company_id').change(function () {
        let shipping_company_id = $(this).val();
        if (shipping_company_id == '')
            $('#searchOrders, #checkOrders').prop('disabled', true)
        else
            $('#searchOrders, #checkOrders').prop('disabled', false)
    })

    $('#checkOrders').on('click', function() {
        let searchOrders = $('#searchOrders').val();
        searchOrders = [...new Set(searchOrders.split('\n').map(value => value.trim()))].join('\n');
        $('#searchOrders').val(searchOrders);
        let shipping_company_id = $('#shipping_company_id').val();

        if (searchOrders && shipping_company_id) {
            $('#checkLoader').show();
            $('#messageContainer, #successData tbody').html("");
            $('#messageContainer, #successData').hide();
            $('#checkOrders').prop('disabled', true);

            $.ajax({
                url: '/api/shipping_report/orders/validate',
                method: 'POST',
                data: {
                    searchOrders, shipping_company_id
                },
                success: function(response) {
                    if (response.error) {
                        $('#messageContainer').show();
                        let template = '<p class="text-danger fw-bold mb-2">هناك أوردرات خاطئة</p>';

                        if ((response.not_found).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات غير موجودة : <span class="fw-bold">`;
                            $.each(response.not_found, function(index, order_code) {
                                template += order_code + " , ";
                            });
                            template += `</span></p>`;
                        }

                        if ((response.not_related_shipping).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات غير تابعة لشركة الشحن : <span class="fw-bold">`;
                            $.each(response.not_related_shipping, function(index, order_code) {
                                template += order_code + " , ";
                            });
                            template += `</span></p>`;
                        }

                        if ((response.not_in_statuses).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات ليس لديها حالات صحيحة : <span class="fw-bold">`;
                            $.each(response.not_in_statuses, function(index, order_code) {
                                template += order_code + " , ";
                            });
                            template += `</span></p>`;
                        }

                        $('#messageContainer').append(template);
                    } else {
                        let message = '<p class="text-success fw-bold m-0">جميع الاوردرات صحيحة سيتم عرض البيانات</p>'
                        $('#messageContainer').append(message).show();

                        let totalOrdersPrice = 0;
                        let totalShippingCost = 0;
                        $.each(response.orders, function(index, order) {
                            totalOrdersPrice += order.total_after_sale;
                            totalShippingCost += order.shipping_co_cost;

                            let row = `<tr>
                                <td><a href="orders/${order.id}" target="_blank">${order.order_code}</a></td>
                                <td>${(order.waybill) ? order.waybill : 'لا يوجد'}</td>
                                <td>${order.name}</td>
                                <td>${order.phone_1}</td>
                                <td>${order.city.name}</td>
                                <td>${order.total_after_sale}</td>
                                <td>${(order.shipping_co_cost) ? order.shipping_co_cost : ''}</td>
                            </tr>`;
                            $('tbody').append(row);
                        })

                        $('#totalOrdersPrice span').text(totalOrdersPrice.toFixed(2));
                        $('#totalShippingCost span').text(totalShippingCost.toFixed(2));
                        $('#totalOrders span').text((response.orders).length);

                        $('#totalOrdersPrice input').val(totalOrdersPrice.toFixed(2));
                        $('#totalShippingCost input').val(totalShippingCost.toFixed(2));
                        $('#totalOrders input').val((response.orders).length);

                        $('#successData').show();
                    }

                    $('#checkLoader').hide();
                    $('#checkOrders').prop('disabled', false);
                }
            })
        }
    })
</script>
@endsection
