@extends('layouts.app')

@section('content')

    <style>
        .remove_variant{
            cursor: pointer;
            color:red;
        }
    </style>


    <div class="modal fade" id="quantities" tabindex="-1" aria-labelledby="quantitiesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <table class="table hover-table">
                        <thead>
                            <tr>
                                <th>اسم المخزن</th>
                                <th>الكمية</th>
                            </tr>
                        </thead>
                        <tbody id="stock">

                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="ProductsModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label" for="product_id">المنتج</label>
                            <select name="product_id" id="product_id" class="form-select product_info" style="padding: 0.375rem 0.75rem;width:100%">
                                <option value="">اختار المنتج</option>
                                @foreach ($products as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-2" id="variants" style="display: none;">
                            <label class="form-label" for="variant_id">المتغيرات</label>
                            <select name="variant_id" id="variant_id" class="form-select variant_info" style="padding: 0.375rem 0.75rem;width:100%">
                            
                                
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary add_variant" >أضافة</button>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
                <li><a class="link-dark" href="{{ route('add_order') }}">اضافة اوردر جديد </a></li>
            </ul>
        </div>

        <div class="card p-3">
            <form id="order_form" method="POST" action="{{route('store_order')}}">
                @csrf
                <div class="row">
                    <h1 class="text-center">أضافة اوردر جديد</h1>
                    <div class="row">
                        <h4>بيانات العميل</h4>
                        <div class="col-md-4">
                            <label class="form-label">الاسم </label>
                            <input type="text" class="form-control @error('client.name') is-invalid @enderror" name="client[name]"
                                id="name" value="{{ old('client.name') }}">
                            @error('client.name')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">رقم التليفون</label>
                            <input type="text" name="client[phone_1]" id="phone_1" list="phone_numbers" class="@error('client.phone_1') is-invalid @enderror form-control"
                                autocomplete="off" placeholder="يمكنك البحث عن عميل برقم الهاتف" value="{{ old('client.phone_1') }}">
                            @error('client.phone_1')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">رقم التليفون 2 </label>
                            <input type="text" class="form-control @error('client.phone_2') is-invalid @enderror" name="client[phone_2]"
                                id="phone_2" value="{{ old('client.phone_2') }}">
                            @error('client.phone_2')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">عنوان <i class="bi bi-map-marker">
                                </i></label>
                            <input type="text" class="form-control @error('client.address') is-invalid @enderror" id="address"
                                name="client[address]" value="{{ old('client.address') }}">
                            @error('client.address')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label"> الدولة </label>
                            <select id="country-select" class="form-select @error('client.country_id') is-invalid @enderror"
                                aria-label="Default select example" name="client[country_id]">
                                <option value="">اختار</option>
                                @foreach ($countries as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('client.country_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">المدينة </label>
                            <select id="city-select" class="form-select @error('client.city_id') is-invalid @enderror"
                                aria-label="Default select example" name="client[city_id]">


                            </select>
                            @error('client.city_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label ">المنطقة </label>
                            <select id="area-select" class="form-select @error('client.area_id') is-invalid @enderror"
                                aria-label="Default select example" name="client[area_id]">

                            </select>
                            @error('client.area_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <h4>المنتجات</h4>
                        @error('items')
                        <div class="alert alert-danger" role="alert">
                            برجاء اضافة منتج واحد على الاقل
                        </div>
                        @enderror
                        @error('items.*.warehouse_id')
                        <div class="alert alert-danger" role="alert">
                            برجاء اختيار المخزن لكل منتج
                        </div>
                        @enderror
                        <table class="table table-hover" id="variants_table">
                            <thead>
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>اسم المتغير</th>
                                    <th>السعر</th>
                                    <th>الكمية المتوفرة</th>
                                    <th>المخزن</th>
                                    <th>الكمية</th>
                                    <th>الاجمالى</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        
                        <div>
                            <a href="" data-bs-toggle="modal" data-bs-target="#ProductsModal" class="btn btn-primary">أضافة منتج الى الاوردر</a>
                        </div>
                    </div>
                    
                </div>
                <div class="row p-3">
                    <button type="submit" class="btn btn-primary btn-lg mt-3 add_order_btn">أضافة الاوردر <i class="bi bi-plus"></i></button>
                </div>
            </form>
        </div>
    </div>

    <datalist id="phone_numbers">
        @foreach ($clients as $client)
            <option value="{{ $client->phone_1 }}">{{ $client->phone_1 }}</option>
        @endforeach
    </datalist>

    <select id="warehouse_select"  style="display: none">
        <option value="">اختار المخزن</option>
        @foreach ($warehouses as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        var items = {!! json_encode(old('items')) !!}
        
        $(document).ready(function() {
            $('select.product_info').select2({
                dropdownParent: $('#ProductsModal')
            });

            if(items){
                Object.entries(items).forEach(element => {
                    var variant_id = element[0];
                    $.ajax({
                        url:`/api/variants/${variant_id}`,
                        method:"GET",
                        dataType:"text",
                    }).then(response =>{
                        var data = JSON.parse(response);
                        data['old_quantity'] = element[1]['quantity'];
                        data['warehouse_id'] = element[1]['warehouse_id'];
                        add_variant(data);
                    })
                });
            }

        })
        $("#phone_1").change(function() {
            var phone = $(this).val();

            $.ajax({
                url: `/api/clients/${phone}`,
                method: "GET",
                dataType: "text",
                error: function() {
                    remove_data();
                },
            }).then(async function(response, textStatus, xhr) {
                remove_data();
                data = JSON.parse(response);

                await $('#city-select').html('<option value="">-- اختار المدينة --</option>');
                await $.each(data.citites, function(key, value) {
                    $("#city-select").append('<option value="' + key + '">' + value +
                        '</option>');
                });

                await $('#area-select').html('<option value="">-- اختار المنطقة --</option>');
                await $.each(data.areas, function(key, value) {
                    $("#area-select").append('<option value="' + key + '">' + value +
                        '</option>');
                });

                await add_data(data);
            })
        })
        function add_data(data) {
            $("#name").val(data.client.name);
            $("#phone_2").val(data.client.phone_2);
            $("#address").val(data.client.address);
            $("#country-select").val(data.client.country_id);
            $("#city-select").val(data.client.city_id);
            $("#area-select").val(data.client.area_id);
            $("#order_form").append(`<input id="client_id" type="hidden" name="client_id" value="${data.client.id}" />`);
        }
        function remove_data() {
            $("#name").val("");
            $("#phone_2").val("");
            $("#address").val("");
            $("#country-select").val("");
            $("#city-select").val("");
            $("#area-select").val("");
            $("#city-select").html("");
            $("#area-select").html("");
            $("#order_form #client_id").remove();
        }
        $("#country-select").change(function() {
            var country_id = $(this).val();
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
        })
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
                    $("#area-select").append('<option value="' + key + '">' + value + '</option>');
                });
            })
        })
        $("#product_id").change(function () {
            product_id = $(this).val();
            $("#variant_id").html("");
            $.ajax({
                url:`/api/product/${product_id}/variants`,
                method:`GET`,
                dataType:'text'
            }).then(response =>{
                data = JSON.parse(response);
                $("#variant_id").append(`<option value="">اختار المتغير</option>`)
                data.forEach(element => {
                    $("#variant_id").append(`<option value="${element.id}">${element.name}</option>`)
                })
                $('#variant_id').select2({
                    dropdownParent: $('#ProductsModal')
                });
                $("#variants").fadeIn();
            })
        })
        $(".add_variant").click(function () {
            var variant_id = $('#variant_id').val();
            var exists = $("tr#"+variant_id).length;
            if(exists){
                var quantity = $("tr#"+variant_id+" .quantity").val();
                if(!quantity){
                    quantity = 0;
                }
                $("tr#"+variant_id+" .quantity").val(parseInt(quantity)+1).trigger('input');
                $("#ProductsModal").modal("hide");
                return;
            }

            $.ajax({
                url:`/api/variants/${variant_id}`,
                method:"GET",
                dataType:"text",
            }).then(response =>{
                var data = JSON.parse(response);
                add_variant(data);
                $("#ProductsModal").modal("hide");
            })
        });
        function add_variant(data) {
            var warehouse_select = $("#warehouse_select").html();
            var template = `
                <tr id="${data.id}">
                    <td>${data.product.name}</td>
                    <td>${data.name}</td>
                    <td>${data.price}</td>
                    <td><a data-id="${data.id}" class="link-primary" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#quantities">${data.quantity}</a></td>
                    <td>
                        <select class="warehouse form-select" name="items[${data.id}][warehouse_id]">
                            ${warehouse_select}
                        </select>
                    </td>
                    <td style="width:80px;">
                        <input type="number" name="items[${data.id}][quantity]" class="form-control quantity" data-price="${data.price}" value="${(data.old_quantity ? data.old_quantity : 1 )}" min="1" data-id="${data.id}" id="quantity-${data.id}" />
                    </td>
                    <td class="variant_total">${data.price}</td>
                    <td class="fs-5 text-danger"><a class="remove_variant" data-id="${data.id}"><i class="bi bi-trash3"></a></td>
                </tr>
            `
            $("#variants_table tbody").append(template);

            if(data.warehouse_id){
                $(`tr#${data.id} .warehouse`).val(data.warehouse_id);
            }
            $('.quantity').trigger('input');
        }
        $(document).on('click','.remove_variant',function (params) {
            var id = $(this).attr('data-id');
            
            $(`tr#${id}`).fadeOut();
            $(`tr#${id}`).remove();
        })
        $("#quantities").on('show.bs.modal',function (e) {
            var id = $(e.relatedTarget).attr('data-id');

            $.ajax({
                url:`/api/variants/${id}/stock`,
                method:"GET",
                dataType: "text",
            }).then(response => {
                data = JSON.parse(response);
                add_stock(data);
            })
        })
        function add_stock(data) {
            $("#stock").html("");
            data.forEach(element => {
                if(element.sum != "0"){
                    var template = `
                    <tr>
                        <td>${element.warehouse.name}</td>
                        <td>${element.sum}</td>
                    </tr>
                    `;
                    $("#stock").append(template);
                }
            });
        }
        $(document).on('input','.quantity',function (e) {
           value = parseInt($(this).val());
           price = parseFloat($(this).attr('data-price'));
           id = $(this).attr('data-id');
           $(`tr#${id} .variant_total`).html(value*price);
        })
        $(".add_order_btn").click(function (e) {
            e.preventDefault();
            console.log("hi 1");

            var warehouses = $("select.warehouse");
            var quantites = $(".quantity");
            
            var error = false;

            for (let index = 0; index < warehouses.length; index++) {
                const warehouse = warehouses[index];
                warehouse_id = $(warehouse).val();
                if(!warehouse_id){
                    error=true;
                    $(warehouse).addClass('is-invalid');
                    $(warehouse).parent().find('.text-danger').remove();
                    $(warehouse).parent().append(`<span class="text-danger">برجاء اختيار المخزن</span>`)
                }else{
                    $(warehouse).removeClass('is-invalid');
                    $(warehouse).parent().find('.text-danger').remove();
                }
            }

            for (let index = 0; index < quantites.length; index++) {
                const quantity = quantites[index];
                value = parseInt($(quantity).val());
                if(!value){
                    error=true;
                    $(quantity).addClass('is-invalid');
                    $(quantity).parent().find('.text-danger').remove();
                    $(quantity).parent().append(`<span class="text-danger">برجاء ادخال كمية</span>`)
                }else{
                    $(quantity).removeClass('is-invalid');
                    $(quantity).parent().find('.text-danger').remove();
                }
            }
            console.log("hi");
            $("#order_form").submit();

        })
    </script>
@endsection
