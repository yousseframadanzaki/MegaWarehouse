@extends('layouts.app')

@section('title')
    {{ __('global.edit_order_title') }}
@endsection

@section('content')
<style>
    .remove_variant{
        cursor: pointer;
        color:red;
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
            radial-gradient(circle 5px, currentColor 95%,#0000),
            linear-gradient(currentColor 50%,#0000 0) 50%/4px 60% no-repeat;
        animation: l1 2s infinite linear;
    }
    .loader:before {
        content: "";
        flex: 1;
        background:linear-gradient(currentColor 50%,#0000 0) 50%/4px 80% no-repeat;
        animation: inherit;
    }
    @keyframes l1 {
        100% {transform: rotate(1turn)}
    }
    </style>
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
                            <input type="number" name="quantity" id="quantity" value="1" class="form-control">
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
                <button type="button" class="btn btn-primary add_to_cart_btn" onclick="add_cart_items()">أضافة</button>
            </div>
        </div>
    </div>
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
                    <div class="table-responsive">
                        <tbody id="stock">

                        </tbody>
                    </div>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('edit_order',$order->id) }}">تعديل بيانات أوردر {{$order->order_code}}</a></li>
        </ul>
    </div>
<div class="card p-3">
    <form id="order_form" method="POST" action="{{route('update_order',$order->id)}}">
        @csrf
        @if (old('client_id'))
            <input id="client_id" type="hidden" name="client_id" value="{{old('client_id')}}" />
        @endif
        <div class="row">
            <div class="row">
                <h4>بيانات العميل</h4>
                <div class="col-md-4">
                    <label class="form-label">الاسم </label>
                    <input type="text" class="form-control @error('client.name') is-invalid @enderror" name="client[name]"
                        id="name" value="{{ $order->name }}">
                    @error('client.name')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">رقم التليفون</label>
                    <input type="text" name="client[phone_1]" id="phone_1" list="phone_numbers" class="@error('client.phone_1') is-invalid @enderror form-control"
                        autocomplete="off" placeholder="يمكنك البحث عن عميل برقم الهاتف" value="{{ $order->phone_1 }}">
                    @error('client.phone_1')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">رقم التليفون 2 </label>
                    <input type="text" class="form-control @error('client.phone_2') is-invalid @enderror" name="client[phone_2]"
                        id="phone_2" value="{{ $order->phone_2 }}">
                    @error('client.phone_2')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mt-3">
                    <label class="form-label">عنوان <i class="bi bi-map-marker">
                        </i></label>
                    <input type="text" class="form-control @error('client.address') is-invalid @enderror" id="address"
                        name="client[address]" value="{{ $order->address }}">
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
                            <option @if ($id == $order->client->country_id)
                                selected
                            @endif value="{{ $id }}">{{ $name }}</option>
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
                        @foreach ($cities as $id => $name)
                            <option @if($order->city_id == $id)
                                selected
                            @endif value="{{ $id }}">{{ $name }}</option>
                        @endforeach

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
                        @foreach ($areas as $area)
                                <option @if($order->area_id == $area->id)
                                    selected
                                @endif value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                    </select>
                    @error('client.area_id')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mt-3">
                    <label class="form-label">سعر الشحن</label>
                    <input type="text" class="form-control @error('delivery_cost') is-invalid @enderror" id="delivery_cost"
                        name="client[delivery_cost]" value="{{ $order->delivery_cost }}">
                </div>
            </div>
                <div class="row mt-5">
                    <h4>المنتجات</h4>
                    @error('items')
                    <div class="alert alert-danger" role="alert">
                        برجاء أضافة منتج واحد على الاقل
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
                                <th>السعر بعد الخصم</th>
                                <th>الكمية المتوفرة</th>
                                <th>المخزن</th>
                                <th>الكمية</th>
                                <th>الاجمالى</th>
                                <th>الاجمالى بعد الخصم</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            @foreach ($order->stocks as $item)
                                <tr id="{{ $item->variant->id }}">
                                    <td>{{$item->variant->product->name}}</td>
                                    <td>{{$item->variant->name}}</td>
                                    <td>{{$item->unit_price}}</td>
                                    <td style="width:80px;">
                                        <input style="width: inherit;" type="number" name="old_items[{{ $loop->index }}][unit_sale]" class="form-control unit_sale" value="{{$item->unit_price_after_sale}}" data-id="{{ $item->variant->id }}" id="unit_sale-{{$item->variant->id}}" required min="0"/>
                                    </td>
                                    <td><a data-id="{{ $item->variant->id }}" class="link-primary" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#quantities">{{$item->variant->quantity}}</a></td>
                                    <td>
                                        <select class="warehouse form-select" data-id="{{ $item->variant->id }}" name="old_items[{{ $loop->index }}][warehouse_id]" required>
                                            @foreach ($warehouses as $id => $name)
                                                <option @if($item->warehouse->id == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width:80px;">
                                        <input type="number" name="old_items[{{ $loop->index }}][quantity]" class="form-control quantity" data-price="{{$item->variant->price}}" value="{{abs($item->quantity)}}" min="1" data-id="{{ $item->variant->id }}" id="quantity-{{ $item->variant->id }}" required min="1"/>
                                    </td>
                                    <td class="total_price">{{abs($item->quantity) * $item->unit_price}}</td>
                                    <td class="total_price_after_sale">{{abs($item->quantity) * $item->unit_price_after_sale}}</td>
                                    <td class="fs-5 text-danger"><a data-id="{{ $item->variant->id }}" onclick="remove_variant(this, {{ $item->id }})" style="cursor: pointer;"><i class="bi bi-trash3"></i></a></td>

                                    <input type="hidden" name="old_items[{{ $loop->index }}][id]" value="{{ $item->variant->id }}"/>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <div class="loader" style="display: none;"></div>
                        <div class="total_total" style="direction: ltr;display: none;">الاجمالى :<span id="total_total_1"></span></div>
                        <input hidden name="client[total]" class="total_input" value="">
                        <div class="total_after_sale" style="direction: ltr;display: none;">الاجمالى بعد الخصم :<span id="total_after_sale_1"></span></div>
                        <input hidden name="client[total_after_sale]" class="total_after_sale_input" value="">
                    <div>
                        <a href="" data-bs-toggle="modal" data-bs-target="#addToCartModal" class="btn btn-primary">أضافة منتج الى الأوردر</a>
                        <button type="button" class="btn btn-primary total_order">عرض اجمالى الأوردر</button>
                    </div>
                </div>

            </div>
            <div class="row p-3">
                <button type="submit" class="btn btn-primary btn-lg mt-3">تعديل الأوردر <i class="bi bi-pencil-fill"></i></button>
            </div>
        </div>
    </form>
</div>
</div>
<select id="warehouses_select"  style="display: none">
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
        $('.unit_sale').change(function() {
            var quantity = parseInt($(this).closest('tr').find('.quantity').val());
            var unitSale = parseFloat($(this).val());
            var totalPriceAfterSale = quantity * unitSale;

            $(this).closest('tr').find('.total_price_after_sale').text(totalPriceAfterSale);
        });
    });
    $(document).ready(function() {
        $(document).on('input', '.quantity',function() {
            var quantity = $(this).val();
            var price = $(this).data('price');
            var total = quantity * price;
            price_after_sale = $(this).closest('tr').find('.unit_sale').val();
            var total_after_sale = quantity * price_after_sale;
            $(this).closest('tr').find('.total_price_after_sale').text(total_after_sale);
            $(this).closest('tr').find('.total_price').text(total);
        });
    });
    $(document).ready(function() {
        $('select.product_info').select2({
            dropdownParent: $('#addToCartModal')
        });
        $('#warehouse_id').select2({
                dropdownParent: $('#addToCartModal')
        });

    })
    $("#country-select").change(function () {
        var country_id = this.value;
        $("#city-select").html('');
        $.ajax({
            type:'GET',
            url:`/api/country/${country_id}/cities`,
            dataType: "text",
        }).then((response)=>{
            data = JSON.parse(response);
            $('#city-select').html('<option value="">-- اختار المدينة --</option>');
            $.each(data, function (key, value) {
                $("#city-select").append('<option value="' + key + '">' + value + '</option>');
            });

        })
    })
    $("#city-select").change(function () {
        var city_id = this.value;
        $("#area-select").html('');
        $.ajax({
            type:'GET',
            url:`/api/city/${city_id}/areas`,
            dataType: "text",
        }).then((response)=>{
            data = JSON.parse(response);
            $('#area-select').html('<option value="">-- اختار المنطقة --</option>');
            $.each(data, function (key, value) {
                $("#area-select").append('<option value="' + value.id + '">' + value.name + '</option>');
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
                if (data.length == 1) { // if only one option add selected attribute and call ajax function.
                    $("#variant_id").append(`<option selected data-hide="${element.hide}" data-confirm="${element.product.confirm_order}" data-show="${element.product.show_quantity}" data-quantity=${element.quantity} data-price="${element.price}" value="${element.id}">${element.name} (السعر: ${element.price})</option>`)
                    variant_select_change($("#variant_id"));
                } else {
                    $("#variant_id").append(`<option data-hide="${element.hide}" data-confirm="${element.product.confirm_order}" data-show="${element.product.show_quantity}" data-quantity=${element.quantity} data-price="${element.price}" value="${element.id}">${element.name} (السعر: ${element.price})</option>`)
                }
            })
            $('#variant_id').select2({
                dropdownParent: $('#addToCartModal')
            });
            $("#variants").fadeIn();
        })
    })

    function remove_variant(el, $id){
        id = $id;
        if(confirm("هل تريد حذف المنتج؟")) {
            $.ajax({
                url:`/api/stock/${id}/remove`,
                method:`POST`,
                dataType:'text'
            }).then(response =>{
                data = JSON.parse(response);
                $(el).closest('tr').remove();
            });
        } else {
            return false;
        }
    }

    $(document).on('input', '.unit_sale', function(e) {
        var price_after_sale = $(this).val();
        var variant_id = $(this).data('id');
        var quantity = $(`#quantity-${variant_id}`).val();
        var totalAfterSale = price_after_sale * quantity;
        $(this).closest('tr').find('.total_price_after_sale').text(totalAfterSale);
    });

    function add_cart_items(){
        var product_id = $("#product_id").val();
        var variant_id = $("#variant_id").val();
        var warehouse_id = $("#warehouse_id").val();
        var quantity = $("#quantity").val();
        var variant_price = $("#variant_id option:selected").attr("data-price");
        var variant_quantity = $("#variant_id option:selected").attr("data-quantity");
        var confirm_order = $('#variant_id option:selected').data("confirm");
        var quantity_sum = $("#quantity_sum_" + warehouse_id).data("sum");
        if(confirm_order == '0' && quantity > quantity_sum) {
            alert('لا يمكنك اضافة هذا المنتج');
            return;
        }

        if(product_id && variant_id && warehouse_id && quantity) {
            $("#addToCartModal").modal('hide');
            
            var variant_found = $(`#items tr#${variant_id}`); // check if the variant is already found.

            if (variant_found.length == 0) {    // new variant.
                var warehouses_select = $("#warehouses_select").html();
                var productName = $("#product_id option:selected").text();
                var variantName = $("#variant_id option:selected").text();
                var warehouseName = $("#warehouse_id option:selected").text();
                var total = variant_price * quantity;
                var index = $('#items tr').length;

                var template = `
                    <tr id="${variant_id}">
                        <td>${productName}</td>
                        <td>${variantName}</td>
                        <td>${variant_price}</td>
                        <td style="width:80px;">
                            <input style="width: inherit;" type="number" name="items[${index}][unit_price_after_sale]" class="form-control unit_sale" value="${variant_price}" data-id="${variant_id}" id="unit_sale-${variant_id}" required min="0"/>
                        </td>
                        <td><a data-id="${variant_id}" class="link-primary" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#quantities">${variant_quantity}</a></td>
                        <td>
                            <select class="warehouse form-select" data-id="${variant_id}" name="items[${index}][warehouse_id]" required>
                                ${warehouses_select}
                            </select>
                        </td>
                        <td style="width:80px;">
                            <input type="number" name="items[${index}][quantity]" class="form-control quantity" data-price="${variant_price}" value="${quantity}" min="1" data-id="${variant_id}" id="quantity-${variant_id}" required min="1"/>
                        </td>
                        <td class="total_price">${total}</td>
                        <td class="total_price_after_sale">${total}</td>
                        <td class="fs-5"><a class="removee_variant text-danger" style="cursor: pointer" data-id="${variant_id}"><i class="bi bi-trash3"></i></a></td>
                        <input type="hidden" name="items[${index}][id]" value="${variant_id}"/>
                        <input type="hidden" name="items[${index}][unit_price]" value="${variant_price}"/>
                    </tr>
                `;

                $("#items").append(template);
                $(`#items tr#${variant_id} .warehouse`).val(warehouse_id);
            } else {    // exist old variant.
                console.log(variant_id + '    ' + variant_found);
                variant_found.find('.warehouse').val(warehouse_id);
                variant_found.find('.quantity').val(quantity);
                variant_found.find('.total_price').text(variant_price * quantity);
                var price_after_sale = variant_found.find('.unit_sale').val();
                var totalAfterSale = price_after_sale * quantity;
                variant_found.find('.total_price_after_sale').text(totalAfterSale);
            }

            // $("#product_id").val('');
            // $("#variant_id").empty().append('<option value="">اختار المتغير</option>');
            // $("#warehouse_id").val('');
            $("#quantity").val(1);
        } else {
            alert('يرجى ملء جميع الحقول');
        }
    }

    $(document).on('change', '#variant_id',function(){variant_select_change($(this))});

    function variant_select_change(variant_select) {
        var variant_id = variant_select.val();
        var show_quantity = variant_select.find('option:selected').data("show");
        var hide = variant_select.find('option:selected').data("hide");

        if (variant_id != '') {
            $.ajax({
                url: `/api/variants/${variant_id}/stock`,
                method: "GET",
                dataType: "text",
            }).then(response => {
                data = JSON.parse(response);
                if(show_quantity == '0'){
                    add_cart_stock(data);
                } else {
                    add_cart_stockk(data);
                }
                if(hide == '1'){
                    add_cart_stockk(data);
                }

            })
        }
    }

    function add_cart_stock(params) {
        $("#cart_stock").html("");
        data.forEach(element => {
                var template = `
                <tr>
                    <td>${element.warehouse.name}</td>
                    <td id="quantity_sum_${element.warehouse.id}" data-sum="${element.sum}">${element.sum}</td>
                </tr>
                `;
                $("#cart_stock").append(template);
        });
    }

    function add_cart_stockk(params) {
        $("#cart_stock").html("");
        data.forEach(element => {
            if(element.sum > "0"){
                var template = `
                <tr>
                    <td>${element.warehouse.name}</td>
                    <td id="quantity_sum_${element.warehouse.id}" data-sum="${element.sum}">متوفر</td>
                </tr>
                `;
                $("#cart_stock").append(template);
            }
            if(element.sum <= "0"){
                var template = `
                <tr>
                    <td>${element.warehouse.name}</td>
                    <td id="quantity_sum_${element.warehouse.id}" data-sum="${element.sum}">غير متوفر</td>
                </tr>
                `;
                $("#cart_stock").append(template);
            }
        });
    }

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
            var template = `
            <tr>
                <td>${element.warehouse.name}</td>
                <td>${element.sum}</td>
            </tr>
            `;
            $("#stock").append(template);
        });
    }

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

    $(document).on('click', '.removee_variant', function () {
        $(this).closest('tr').remove();
    });

    $(".total_order").click(function (e) {
        var total = 0;
        var totalAfterSale = 0;
        $(".loader").show();

        $('tr').each(function() {
            var variantTotal = parseInt($(this).find('.total_price').text().trim());
            var variantTotalAfterSale = parseInt($(this).find('.total_price_after_sale').text().trim());

            if (!isNaN(variantTotal)) {
                total += variantTotal;
            }
            if (!isNaN(variantTotalAfterSale)) {
                totalAfterSale += variantTotalAfterSale;
            }
        });

        var formattedTotal = total.toLocaleString();
        var formattedTotalAfterSale = totalAfterSale.toLocaleString();
        setTimeout(function() {
            $(".total_total").show();
            $(".total_after_sale").show();
            $('#total_total_1').text(formattedTotal);
            $('#total_after_sale_1').text(formattedTotalAfterSale);
            $(".loader").hide();
        }, 1500);
    });

    $("#order_form").on('submit', function(e) {
        e.preventDefault();
        var total = 0;
        var totalAfterSale = 0;

        $('tr').each(function() {
            var variantTotal = parseInt($(this).find('.total_price').text().trim());
            var variantTotalAfterSale = parseInt($(this).find('.total_price_after_sale').text().trim());

            if (!isNaN(variantTotal)) {
                total += variantTotal;
            }
            if (!isNaN(variantTotalAfterSale)) {
                totalAfterSale += variantTotalAfterSale;
            }
        });

        var formattedTotal = total.toLocaleString();
        var formattedTotalAfterSale = totalAfterSale.toLocaleString();
        $('.total_input').val(formattedTotal);
        $('.total_after_sale_input').val(formattedTotalAfterSale);
        this.submit();
    });
</script>
@endsection
