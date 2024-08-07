@extends('layouts.store_app')

@section('content')
    <style>
        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input, select {
            background-color: white !important;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center my-4"> الأوردر الحالي</h3>
            </div>
        </div>
        <form action="" class="border border-secondary px-4 pb-3 rounded">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center my-3">بيانات العميل</h5>
                    <hr>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_name">الاسم</label>
                        <input type="text" class="form-control" name="client[name]" id="client_name" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_phone">رقم التليفون</label>
                        <input type="text" class="form-control" name="client[phone]" id="client_phone" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_address">العنوان</label>
                        <input type="text" class="form-control" name="client[address]" id="client_address" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="city_id">المدينة</label>
                        <select class="form-control" name="client[city_id]" id="city_id" required></select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="area_id">المنطقة</label>
                        <select class="form-control" name="client[area_id]" id="area_id" required></select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <h5 class="text-center my-3">محتويات الاوردر</h5>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="min-width: 800px;" id="order_items_table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>المتغير</th>
                                    <th>سعر الوحدة</th>
                                    <th style="width: 100px !important;">الكمية</th>
                                    <th>السعر الكلي</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <p>إجمالي الأوردر: <span></span></p>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let variant_ids = sessionStorage.getItem('cart') || '';

            if (variant_ids != '') {
                $.ajax({
                    url: '/api/get_bulk_variants_data',
                    method: 'GET',
                    data: {
                        ids: variant_ids
                    },
                    success: function(data) {
                        $.each(data, function(index, variant) {
                            let template = `
                                <tr data-id="${variant.id}">
                                    <td>${variant.product.name}</td>
                                    <td>${variant.name}</td>
                                    <td class="unit_price">${variant.product.price}</td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="order_items[${index}][quantity]" value="1" min="1" required>
                                    </td>
                                    <td class="total_price_text">${variant.product.price}</td>
                                    <input type="hidden" class="variant_id" name="order_items[${index}][variant_id]" value="${variant.id}">
                                    <input type="hidden" class="total_price_input" name="order_items[${index}][price]" value="${variant.product.price}">
                                </tr>
                            `;

                            $('tbody').append(template);
                        })
                    }
                })
            }
        })

        $(document).on('input', '.quantity', function() {
            if ($(this).val() != '') {
                let total_price_text = $(this).closest('tr').find('.total_price_text');
                let total_price_input = $(this).closest('tr').find('.total_price_input');
                let quantity = $(this).val();
                let unit_price = $(this).closest('tr').find('.unit_price').text();

                total_price_text.text(unit_price * quantity);
                total_price_input.val(unit_price * quantity);
            }
        })
    </script>
@endsection
