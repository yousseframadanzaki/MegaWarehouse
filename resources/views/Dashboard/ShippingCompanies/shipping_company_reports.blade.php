@extends('layouts.app')

@section('title')
    تقارير التوريدات
@endsection

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark"> تقارير توريدات شركة الشحن </a></li>
            </ul>
        </div>
        <div class="row mt-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm p-4">
                    <form method="POST" action="{{ route('shipping_orders_results') }}" id="search">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-12">
                                <label class="form-label fw-bold">شركة الشحن</label>
                            </div>
                            <div class="col-12">
                                <select class="form-select product_info"  name="shipping_company_id" id="shipping_company_id" style="padding: 0.375rem 0.75rem;" required>
                                    <option value="">اختار شركة الشحن</option>
                                    @foreach ($shipping_companies as $shipping_company2)
                                        <option value="{{ $shipping_company2->id }}" @if(!empty($shipping_company->id) && $shipping_company->id == $shipping_company2->id) selected @endif>{{ $shipping_company2->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label fw-bold">الأوردرات <span class="text-secondary"> ( اختار شركة الشحن أولا ) </span></label>
                            </div>
                            <div class="col-12" dir="rtl">
                                <textarea name="" rows="2" dir="rtl" id="searchOrders" class="w-100 form-control" rows="10" placeholder="" disabled></textarea>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button type="button" class="btn btn-primary" id="checkOrders" disabled> فحص الأوردرات </button>
                            </div>
                            <div class="mt-4" id="errorsContainer" style="display: none;">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card p-3 shadow-sm mt-4">
                    <h5 class="mt-2 mb-4">إجمالي الأوردرات : <span class="fw-bold" id="totalOrders"></span></h5>
                        <div class="table-responsive">
                            <table class="table table-hover mb-2">
                                <thead>
                                    <tr>
                                        <th>رقم الأوردر</th>
                                        <th>رقم البوليصة</th>
                                        <th>اسم العميل</th>
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
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
        let shipping_company_id = $('#shipping_company_id').val();

        if (searchOrders && shipping_company_id) {
            $('#errorsContainer').html("");
            $('#errorsContainer').hide();
            $('#checkOrders').prop('disabled', true);

            $.ajax({
                url: '/api/shipping_report/orders/validate',
                method: 'POST',
                data: {
                    searchOrders, shipping_company_id
                },
                success: function(response) {
                    if (response.error) {
                        $('#errorsContainer').show();
                        let template = '';

                        if ((response.not_found).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات غير موجودة : <span class="fw-bold">`;
                            $.each(response.not_found, function(index, order_code) {
                                template += order_code + ", ";
                            });
                            template += `</span></p>`;
                        }

                        if ((response.not_related_shipping).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات غير تابعة لشركة الشحن : <span class="fw-bold">`;
                            $.each(response.not_related_shipping, function(index, order_code) {
                                template += order_code + ", ";
                            });
                            template += `</span></p>`;
                        }

                        if ((response.not_in_statuses).length > 0) {
                            template += `<p class="text-danger mb-2"> أوردرات ليس لديها حالات : <span class="fw-bold">`;
                            $.each(response.not_in_statuses, function(index, order_code) {
                                template += order_code + ", ";
                            });
                            template += `</span></p>`;
                        }

                        $('#errorsContainer').append(template);
                    } else {
                        $.each(response.orders, function(index, order) {
                            let row = `<tr>
                                <td>${order.order_code}</td>
                                <td>${(order.waybill) ? order.waybill : 'لا يوجد'}</td>
                                <td>${order.name}</td>
                                <td>${order.city.name}</td>
                                <td>${order.total_after_sale}</td>
                                <td>${(order.shipping_co_cost) ? order.shipping_co_cost : ''}</td>
                            </tr>`;
                            $('tbody').append(row);
                        })
                    }

                    $('#checkOrders').prop('disabled', false);
                }
            })
        }
    })
</script>
@endsection
