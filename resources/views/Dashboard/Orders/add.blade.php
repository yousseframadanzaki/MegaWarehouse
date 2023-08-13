@extends('layouts.app')

@section('content')

    <style>
        .remove_variant{
            cursor: pointer;
            color:red;
        }
    </style>

    <div id="message" style="display: none">

    </div>
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

    {{-- <div class="modal fade" id="ProductsModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('store_cart')}}" method="POST" id="cart_form">
                        @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label" for="product_id">المنتج</label>
                            <select id="product_id" class="form-select product_info" style="padding: 0.375rem 0.75rem;width:100%">
                                <option value="">اختار المنتج</option>
                                @foreach ($products as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-2" id="variants">
                            <label class="form-label" for="variant_id">المتغيرات</label>
                            <select name="variant_id" id="variant_id" class="form-select variant_info" style="padding: 0.375rem 0.75rem;width:100%">
                            
                                
                            </select>
                        </div>
                        <div class="col-md-12 mt-2" >
                            <label class="form-label" for="warehouse_id">المخزن</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select"
                                style="padding: 0.375rem 0.75rem;width:100%">
                                <option value="">اختار المخزن</option>
                                @foreach ($warehouses as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">الكمية</label>
                            <input type="number" name="quantity" id="quantity" class="form-control">
                        </div>
                        <div class="col-md-12 mt-2">
                            <table class="table hover-table">
                                <thead>
                                    <tr>
                                        <th>اسم المخزن</th>
                                        <th>الكمية</th>
                                    </tr>
                                </thead>
                                <tbody id="cart_stock">

                                </tbody>
                            </table>
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
    </div> --}}

    <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="cart_form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" for="product_id">المنتج</label>
                                <select id="product_id" class="form-select product_info" style="padding: 0.375rem 0.75rem;width:100%">
                                    <option value="">اختار المنتج</option>
                                    @foreach ($products as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-2" id="variants">
                                <label class="form-label" for="variant_id">المتغيرات</label>
                                <select name="variant_id" id="variant_id" class="form-select variant_info"
                                    style="padding: 0.375rem 0.75rem;width:100%">
                                </select>
                            </div>
                            <div class="col-md-12 mt-2" >
                                <label class="form-label" for="warehouse_id">المخزن</label>
                                <select name="warehouse_id" id="warehouse_id" class="form-select"
                                    style="padding: 0.375rem 0.75rem;width:100%">
                                    <option value="">اختار المخزن</option>
                                    @foreach ($warehouses as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">الكمية</label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="col-md-12 mt-2">
                                <table class="table hover-table">
                                    <thead>
                                        <tr>
                                            <th>اسم المخزن</th>
                                            <th>الكمية</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart_stock">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary add_to_cart_btn">أضافة</button>
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
                                {{-- @if (Session::has('cart'))
                                    @foreach (Session::get('cart') as $item)
                                        
                                    @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                        
                        <div>
                            <a href="" data-bs-toggle="modal" data-bs-target="#addToCartModal" class="btn btn-primary">أضافة منتج الى الاوردر</a>
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

        
        
        $(document).ready(function() {
            var items = {!! json_encode(Session::get('cart')) !!}
            $('select.product_info').select2({
                dropdownParent: $('#addToCartModal')
            });
            $('#warehouse_id').select2({
                    dropdownParent: $('#addToCartModal')
            });
            if(items){
                add_cart_items(items);
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
                    dropdownParent: $('#addToCartModal')
                });
                $("#variants").fadeIn();
            })
        })

        function add_cart_items(items){
            $("#variants_table tbody").html("");
            var warehouse_select = $("#warehouse_select").html();
            items.forEach(item => {
                variant = item['variant'];
                var template = `
                    <tr id="${variant.id}">
                        <td>${variant.product.name}</td>
                        <td>${variant.name}</td>
                        <td>${variant.price}</td>
                        <td><a data-id="${variant.id}" class="link-primary" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#quantities">${variant.quantity}</a></td>
                        <td>
                            <select class="warehouse form-select" data-id="${variant.id}" name="items[${variant.id}][warehouse_id]">
                                ${warehouse_select}
                            </select>
                        </td>
                        <td style="width:80px;">
                            <input type="number" name="items[${variant.id}][quantity]" class="form-control quantity" data-price="${variant.price}" value="${(item.quantity ? item.quantity : 1 )}" min="1" data-id="${variant.id}" id="quantity-${variant.id}" />
                        </td>
                        <td class="variant_total">${parseInt(variant.price) * parseInt(item.quantity)}</td>
                        <td class="fs-5 text-danger"><a class="remove_variant" data-id="${variant.id}"><i class="bi bi-trash3"></a></td>
                    </tr>
                `
                $("#variants_table tbody").append(template);
                if(item.warehouse_id){
                    $(`tr#${variant.id} .warehouse`).val(item.warehouse_id);
                }
            });
        }

        $('#variant_id').change(function () {
            var variant_id = $(this).val();

            $.ajax({
                url: `/api/variants/${variant_id}/stock`,
                method: "GET",
                dataType: "text",
            }).then(response => {
                data = JSON.parse(response);
                add_cart_stock(data);
            })
        })

        function add_cart_stock(params) {
            $("#cart_stock").html("");
            data.forEach(element => {
                if(element.sum != "0"){
                    var template = `
                    <tr>
                        <td>${element.warehouse.name}</td>
                        <td>${element.sum}</td>
                    </tr>
                    `;
                    $("#cart_stock").append(template);
                }
            });
        }

        $(".add_to_cart_btn").click(function (e) {
            e.preventDefault();
            var variant_id = $('#variant_id').val();
            var warehouse_id = $('#warehouse_id').val();
            var quantity = $('#quantity').val();

            if (!variant_id) {
                alert('برجاء اختيار المتغير');
                return;
            }
            if (!warehouse_id) {
                alert('برجاء اختيار المخزن');
                return;
            }
            if (!quantity) {
                alert('برجاء اختيار الكمية');
                return;
            }

            const item = {
                variant_id,
                warehouse_id,
                quantity
            };
            $.ajax({
                url:'/api/cart/add',
                method:'POST',
                data:item,
                dataType:'json'
            }).then(data =>{
                if(data){
                    $("#addToCartModal").modal('hide');
                    show_success('تمت الاضافة بنجاح');
                    $(window).scrollTop(0);
                    add_cart_items(data);
                }
            })
        });

        function show_success(message) {
            var template = `
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            $('#message').append(template);
            $('#message').fadeIn();
        }

        $(document).on('input','.quantity',function (e) {
           variant_id = $(this).attr('data-id');
           quantity = parseInt($(this).val());
           warehouse_id = $(`tr#${variant_id} .warehouse`).val();

           price = parseFloat($(this).attr('data-price'));
           
           $(`tr#${variant_id} .variant_total`).html(quantity*price);

           var item = {
            variant_id,
            quantity,
            warehouse_id,
           }

           $.ajax({
            url:'/api/cart/update',
            method:'POST',
            data:item,
            dataType:'json'
           }).then(data => {
            if(!data){
                alert('حدث خطاء أثناء التعديل');
            }
           })


        })

        $(document).on('input','.warehouse',function (e) {
           variant_id = $(this).attr('data-id');
           quantity = $(`tr#${variant_id} .quantity`).val();
           warehouse_id = $(this).val();

           var item = {
            variant_id,
            quantity,
            warehouse_id,
           }

           $.ajax({
            url:'/api/cart/update',
            method:'POST',
            data:item,
            dataType:'json'
           }).then(data => {
            if(!data){
                alert('حدث خطاء أثناء التعديل');
            }
           })
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

        $(document).on('click','.remove_variant',function (params) {
            var variant_id = $(this).attr('data-id');
            $.ajax({
                url:`/api/cart/${variant_id}/delete`,
                method:'POST',
                dataType:'json'
            }).then(data => {
                if(data){
                    $(`tr#${variant_id}`).fadeOut();
                    $(`tr#${variant_id}`).remove();
                }
            })
        })
 

        
        // $(".add_order_btn").click(function (e) {
        //     e.preventDefault();
        //     console.log("hi 1");

        //     var warehouses = $("select.warehouse");
        //     var quantites = $(".quantity");
            
        //     var error = false;

        //     for (let index = 0; index < warehouses.length; index++) {
        //         const warehouse = warehouses[index];
        //         warehouse_id = $(warehouse).val();
        //         if(!warehouse_id){
        //             error=true;
        //             $(warehouse).addClass('is-invalid');
        //             $(warehouse).parent().find('.text-danger').remove();
        //             $(warehouse).parent().append(`<span class="text-danger">برجاء اختيار المخزن</span>`)
        //         }else{
        //             $(warehouse).removeClass('is-invalid');
        //             $(warehouse).parent().find('.text-danger').remove();
        //         }
        //     }

        //     for (let index = 0; index < quantites.length; index++) {
        //         const quantity = quantites[index];
        //         value = parseInt($(quantity).val());
        //         if(!value){
        //             error=true;
        //             $(quantity).addClass('is-invalid');
        //             $(quantity).parent().find('.text-danger').remove();
        //             $(quantity).parent().append(`<span class="text-danger">برجاء ادخال كمية</span>`)
        //         }else{
        //             $(quantity).removeClass('is-invalid');
        //             $(quantity).parent().find('.text-danger').remove();
        //         }
        //     }
        //     if(error){
        //         return;
        //     }
        //     $("#order_form").submit();

        // })
    </script>
@endsection
