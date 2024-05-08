@extends('layouts.app')
<style>
    .remove_order{
        cursor: pointer;
        color:red;
    }
    </style>
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('scan_order',$order->id) }}">مراجعة أوردر {{$order->order_code}}</a></li>
        </ul>
    </div>
<div id="message" style="display: none"></div>
<form method="POST" id="confirm_order" action="{{route('confirm_order',$order->id)}}">
    @csrf
    <div class="row mt-4">
        <input hidden name="id" value="{{$order->id}}">
        <h3>المنتجات</h3>
        <table class="table table-hover" id="variants_table">
            <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>اسم المتغير</th>
                    <th>المخزن</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الاجمالى</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->stocks as $item)
                    <tr class="items" id="{{$item->variant->sku}}" data-sku="{{$item->variant->sku}}">
                        <td data-product="{{$item->variant->product->name}}">{{$item->variant->product->name}}</td>
                        <td data-variant="{{$item->variant->name}}">{{$item->variant->name}}</td>
                        <td>{{$item->warehouse->name}}</td>
                        <td>{{$item->unit_price}}</td>
                        <td data-quantity="{{abs($item->quantity)}}">{{abs($item->quantity)}}</td>
                        <td>{{abs($item->quantity) * $item->unit_price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-6" style="height: 555px">
            <textarea name="scan_ids" id="scan_ids" cols="20" rows="10" style="width: 50%; height: 100%;"></textarea>
        </div>
        <div class="col-md-6" style="margin-right: -200px;">
            <div class="row mt-4">
                <h3 style="text-align: right;">المنتجات</h3>
                <table class="table table-hover" id="variants_table">
                    <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>اسم المتغير</th>
                            <th>الكمية</th>
                            <th>حذف </th>
                        </tr>
                    </thead>
                    <tbody id="scan_items">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <button type="button" class="btn col-md-12 btn-lg btn-primary mt-3 confirm_order">
         تأكيد التحضير <i class="bi bi-upc-scan"></i>
        </button>
</div>
</form>
@endsection
@section('script')
<script>
    $("#scan_ids").on('keypress',function(e) {
        var input = $("#scan_ids").val();
        var scanned_ids = [];
        input = input.replace(/\[/g, '').replace(/\]/g, '').replace(/\t/g, '');
        var ids = input.split('\n');
        var newId = ids.filter(function(id) {
            return !scanned_ids.includes(id);
        });
        let id = newId.toString();
        scanned_ids.push(...newId);

        if(e.which == 13) {
            $.ajax({
                url:`/api/order/scan_items/`,
                method:'POST',
                data:{ id},
                }).then(data => {
                    if (data) {
                        for (var i = 0; i < data.length; i++) {
                            var item = data[i];
                            var row_index = $('.items_row').length;
                            var template =
                                `<tr class="items_row" id="sku_${row_index}" data-sku="${item.sku}">
                                    <td class="product_${item.sku}">${item.product.name}</td>
                                    <td class="variant_${item.sku}">${item.name}</td>
                                    <td class="quantity_${item.sku}">1</td>
                                    <td class="fs-5 text-danger"><center><a id="${row_index}" class="remove_order" data-remove="${row_index}" data-sku="${item.sku}"><i class="bi bi-trash3"></i></a></center></td>
                                </tr>`;
                            $("#scan_items").append(template);
                        }
                        for (var i = 0; i < data.length; i++) {
                            var productName = $('tr#' + item.sku + ' td[data-product]').attr('data-product');
                            var variantName = $('tr#' + item.sku + ' td[data-variant]').attr('data-variant');

                            if (productName == item.product.name) {
                                $('.items_row').find('.product_' + item.sku).css({backgroundColor: '#46b346',color: 'white'});
                            } else {
                                $('.items_row').find('.product_' + item.sku).css({backgroundColor: '#d93737',color: 'white'});
                            }
                            if (variantName == item.name) {
                                $('.items_row').find('.variant_' + item.sku).css({backgroundColor: '#46b346',color: 'white'});
                            } else {
                                $('.items_row').find('.variant_' + item.sku).css({backgroundColor: '#d93737',color: 'white'});
                            }
                        }
                    }
                    $("#scan_ids").val('');
                        $('.items').each(function (index) {
                            var sku = $(this).attr("data-sku");
                            var count = $('.items_row').find('.quantity_' + sku).length;
                            var quantity_count = $('tr#' + sku + ' td[data-quantity]').attr('data-quantity');

                                if(count == quantity_count){
                                    $('.items_row').find(".quantity_" + sku).css({backgroundColor: '#46b346',color: 'white'});
                                } else {
                                    $('.items_row').find(".quantity_" + sku).css({backgroundColor: '#d93737',color: 'white'});
                                }
                        });
                });
        }
    });
    $(document).on('click', '.remove_order', function () {
        var index = $(this).attr('data-remove');
        var sku = $(this).attr('data-sku');
        $('#sku_' + index).fadeOut(300, function () {
            $(this).index() - 1;
            $(this).remove();
            reload_scan(sku);
        });
    });
    function reload_scan(sku){
        $('.items').each(function (index) {
            var count = $('.items_row').find('.quantity_' + sku).length;
            var quantity_count = $('tr#' + sku + ' td[data-quantity]').attr('data-quantity');

                if(count == quantity_count){
                    $('.items_row').find(".quantity_" + sku).css({backgroundColor: '#46b346',color: 'white'});
                } else {
                    $('.items_row').find(".quantity_" + sku).css({backgroundColor: '#d93737',color: 'white'});
                }
        });
    };
    $(document).on('click', '.confirm_order', function () {
        var totalQuantity = 0;
        $('td[data-quantity]').each(function() {
            totalQuantity += parseInt($(this).data('quantity'));
        });

        var count = $('.items_row').length;
        if (count == totalQuantity) {
            $("#confirm_order").submit();
        } else {
            show_error('يوجد مشكلة فى مراجعة الأوردر');
            $(window).scrollTop(0);
        }

    });
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
