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
                <input type="hidden" name="client_id" id="client_id">
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_name">الاسم</label>
                        <input type="text" class="form-control" name="client[name]" id="client_name" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_phone_1">رقم التليفون</label>
                        <input type="text" class="form-control fixNumbers" name="client[phone_1]" id="client_phone_1" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_phone_2">رقم التليفون 2</label>
                        <input type="text" class="form-control fixNumbers" name="client[phone_2]" id="client_phone_2" required>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_email">الايميل</label>
                        <input type="text" class="form-control" name="client[email]" id="client_email" required>
                    </div>
                </div> --}}
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_address">العنوان</label>
                        <input type="text" class="form-control" name="client[address]" id="client_address" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3 d-none">
                    <div class="form-group">
                        <label for="country-select">البلد</label>
                        <select class="form-select" name="client[country_id]" id="country-select" required>
                            <option value="">اختار</option>
                            @foreach ($countries as $id => $name)
                                <option value="{{ $id }}" @if ($name == "Egypt") selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="city_id">المدينة</label>
                        <select class="form-select" name="client[city_id]" id="city-select" required></select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="area_id">المنطقة</label>
                        <select class="form-select" name="client[area_id]" id="area-select" required></select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="delivery_cost">سعر الشحن</label>
                        <input class="form-control" name="client[delivery_cost]" id="delivery_cost" required min="0" readonly>
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
                        <table class="table table-bordered table-striped" id="order-items" style="min-width: 800px;" id="order_items_table">
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
                    <p>إجمالي الأوردر: <span class="fw-bold" id="total_order"></span></p>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('#city-select, #area-select').select2();

        $(window).on('load', function() { country_select("#country-select") });
        $("#country-select").change(function() { country_select("#country-select") })

        function country_select(el) {
            var country_id = $(el).val();
            $("#city-select").html('');
            $.ajax({
                type: 'GET',
                url: `/api/country/${country_id}/cities`,
                dataType: "text",
            }).then((response) => {
                data = JSON.parse(response);
                $('#city-select').html('<option value="">-- اختار المدينة --</option>');
                $.each(data, function(key, value) {
                    $("#city-select").append('<option value="' + key + '">' + value + '</option>');
                });

            })
        }

        $("#city-select").change(function() {
            var city_id = this.value;
            $("#area-select").html('');
            $.ajax({
                type: 'GET',
                url: `/api/city/${city_id}/areas`,
                dataType: "text",
            }).then((response) => {
                data = JSON.parse(response);
                $('#area-select').html('<option value="">-- اختار المنطقة --</option>');
                $.each(data, function(key, value) {
                    $("#area-select").append(`<option value="${value.id}"> ${value.name} ${value.keywords !== null ? `- ( ${value.keywords} )` : '' }</option>`);
                });
            })
        })

        $("#area-select").change(function() {
            var id = this.value;
            $.ajax({
                type: 'GET',
                url: `/api/area/${id}/get_price`,
                dataType: "text",
            }).then((response) => {
                data = JSON.parse(response);
                $("#delivery_cost").val(data);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let cart = JSON.parse(localStorage.getItem('cart')) || '';

            if (cart != '') {
                $.ajax({
                    url: '/api/get_bulk_variants_data',
                    method: 'GET',
                    data: {
                        ids: JSON.stringify(cart.map(item => item.id))
                    },
                    success: function(data) {
                        let sum = 0;
                        $.each(data, function(index, variant) {
                            let template = `
                                <tr data-id="${variant.id}">
                                    <td>${variant.product.name}</td>
                                    <td>${variant.name}</td>
                                    <td class="unit_sale">${variant.product.price}</td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="items[${index}][quantity]" value="${cart[index].quantity}" min="1" required>
                                    </td>
                                    <td class="total_price_text">${cart[index].quantity * variant.product.price}</td>
                                    <input type="hidden" name="items[${index}][unit_sale]" value="${variant.product.price}">
                                    <input type="hidden" name="items[${index}][id]" value="${variant.id}">
                                </tr>
                            `;

                            $('#order-items tbody').append(template);
                            sum += (cart[index].quantity * variant.product.price);
                        })

                        $('#total_order').text(sum);
                    }
                })
            }
        })

        $(document).on('input', '.quantity', function() {
            if ($(this).val() != '') {
                let total_price_text = $(this).closest('tr').find('.total_price_text');
                let total_price_input = $(this).closest('tr').find('.total_price_input');
                let quantity = $(this).val();
                let unit_sale = $(this).closest('tr').find('.unit_sale').text();

                total_price_text.text(unit_sale * quantity);
                total_price_input.val(unit_sale * quantity);

                let sum = 0;
                $('#order-items .total_price_text').each(function () {
                    sum += Number($(this).text());
                });

                $('#total_order').text(sum);
            }
        })
    </script>

    <script>
        $("#client_phone_1").on('keyup', function() {
            remove_data();

            var phone = $(this).val();

            if (phone.length > 10) {
                $.ajax({
                    url: `/api/clients/${phone}`,
                    method: "GET",
                    dataType: "text",
                }).then(async function(response, textStatus, xhr) {
                        data = JSON.parse(response);

                        await $.each(data.citites, function(key, value) {
                            $("#city-select").append('<option value="' + key + '">' + value +
                                '</option>');
                        });

                        await $.each(data.areas, function(key, value) {
                            $("#area-select").append('<option value="' + value.id + '">' + value.name + '</option>');
                            $("#delivery_cost").val(value.price);
                        });

                        await add_data(data);
                    },
                    async function(response, textStatus, xhr) {
                        if (textStatus === "error") {
                            $("#client_id").attr('value', '');
                        }
                    })
            }
        })

        function add_data(data) {
            $("#client_name").val(data.client.name);
            $("#client_phone_2").val(data.client.phone_2);
            $("#client_address").val(data.client.address);
            $("#country-select").val(data.client.country_id);
            $("#city-select").val(data.client.area.city_id);
            $("#area-select").val(data.client.area_id);
            $("#client_id").attr('value', data.client.id);
            $("#city-select, #area-select").select2();
        }

        function remove_data() {
            $("#client_name").val("");
            $("#client_phone_2").val("");
            $("#client_address").val("");
            $("#country-select").val("");
            $("#city-select").val("");
            $("#area-select").val("");
            $("#city-select").html("");
            $("#area-select").html("");
            $("#client_id").attr('value', '');
            $("#delivery_cost").val("");
        }
    </script>
@endsection
