@extends('layouts.app')

@section('title')
    {{ __('global.related_shipping_orders') }}
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

    .accordion-button::after {
        margin-left: 0px;
        margin-right: auto;
        background-color: white;
        border-radius: 50%;
        padding: 15px;
        background-position: center;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion {
        --bs-accordion-border-color: #7245a4;
    }

    .accordion-button,
    .accordion-button:not(.collapsed) {
        background-color: #7245a4;
        color: white;
        font-weight: bold
    }
</style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark">أوردرات قيد الشحن</a></li>
            </ul>
        </div>
        <div class="row mt-4">
            <div class="col-12 mx-auto">
                <div class="card shadow-sm p-3">
                    <form method="POST" action="{{ route('shipping_orders_results') }}" id="search">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 col-lg-2">
                                <label class="form-label">شركة الشحن</label>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9">
                                <select class="form-select product_info"  name="shipping_company_id" id="shipping_company_id" style="padding: 0.375rem 0.75rem;" required>
                                    <option value="">اختار شركة الشحن</option>
                                    @foreach ($shipping_companies as $shipping_company2)
                                        <option value="{{ $shipping_company2->id }}" @if(!empty($shipping_company->id) && $shipping_company->id == $shipping_company2->id) selected @endif>{{ $shipping_company2->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-md-none mt-2"></div>
                            <div class="col-12 col-md-2 col-lg-1">
                                <button type="submit" class="btn btn-primary">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (!empty($statuses))
                <div class="col-12">
                    <div class="card p-3 shadow-sm mt-4">
                        <h5 class="mt-2 mb-4">إجمالي الأوردرات : <span class="fw-bold">{{ $orders_number }}</span></h5>
                        <div class="accordion" id="accordionExample">
                            @foreach ($statuses as $status)
                                <div class="accordion-item rounded @if($loop->iteration < count($statuses)) mb-2 @endif">
                                    <h2 class="accordion-header" id="panels-heading{{$status['id']}}">
                                        <button class="accordion-button rounded px-4 py-2 get_orders" data-status ="{{$status['id']}}" type="button" data-bs-toggle="collapse" data-bs-target="#panels-collapse{{$status['id']}}" aria-expanded="true" aria-controls="panels-collapse{{$status['id']}}">
                                            {{$status['name']}} <span class="d-inline-block fw-bold mx-3">( {{ $status->orders->where('shipping_company_id', $shipping_company->id)->count() }} )</span>
                                        </button>
                                    </h2>
                                    <div id="panels-collapse{{$status['id']}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample" aria-labelledby="panels-heading{{$status['id']}}">
                                        <div class="accordion-body">
                                            <div class="responsive">
                                                <table class="table table-hover mb-0 d-none">
                                                    <thead>
                                                        <tr>
                                                            <th>رقم الأوردر</th>
                                                            <th>رقم البوليصة</th>
                                                            <th>اسم العميل</th>
                                                            <th>المنطقة</th>
                                                            <th>مبلغ التحصيل</th>
                                                            <th>مبلغ الشحن</th>
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
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $('select').select2();
    $(document).on("click", ".get_orders", function(e) {
        accordion = $(this).closest('.accordion-item');
        table = accordion.find('table');

        if (table.hasClass('d-none') && accordion.find('#loading-parent').length == 0) {
            accordion.find('.accordion-body').append('<div class="text-center" id="loading-parent"><div id="loading" class="my-4"></div></div>');
            status_id = $(this).attr("data-status");
            shipping_company_id = $('#shipping_company_id').val();
            $.ajax({
                url: '/api/shipping_company/orders',
                method: 'get',
                data: {
                    status_id, shipping_company_id
                },
                success: function(response) {
                    accordion.find('#loading-parent').remove();
                    table.removeClass('d-none');
                    data = response.data;
                    $.each(data, function(key, value) {
                        row = `
                            <tr>
                                <td>${value.order_code}</td>
                                <td>${value.waybill}</td>
                                <td>${value.name}</td>
                                <td>${value.city.name} - ${value.area.name}</td>
                                <td>${value.total_after_sale}</td>
                                <td>${value.delivery_cost}</td>
                                <td>${value.delivery_cost}</td>
                            </tr>
                        `;

                        table.find('tbody').append(row);
                    })
                }
            })
        }
    });
</script>
@endsection
