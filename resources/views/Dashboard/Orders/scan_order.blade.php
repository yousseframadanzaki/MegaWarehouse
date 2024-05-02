@extends('layouts.app')
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('scan_order',$order->id) }}">مراجعة أوردر {{$order->order_code}}</a></li>
        </ul>
    </div>
<form method="POST" action="{{route('confirm_order',$order->id)}}">
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
                    <tr>
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
        <div class="col-md-6">
            <textarea name="scan_ids" id="scan_ids" cols="20" rows="10" style="width: 50%; height: 100%;"></textarea>
        </div>
    </div>
    <div class="row mt-4">
        <h3>المنتجات</h3>
        <table class="table table-hover" id="variants_table">
            <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>اسم المتغير</th>
                    <th>الكمية</th>
                </tr>
            </thead>
            <tbody id="scan_items">
            </tbody>
        </table>
    </div>
        <button type="submit" class="btn col-md-12 btn-lg btn-primary mt-3">
         تأكيد الأوردر <i class="bi bi-upc-scan"></i>
        </button>
</div>
</form>
@endsection
@section('script')
<script>
    $("#scan_ids").on('keypress',function(e) {
        var input = $("#scan_ids").val();
        var scanned_ids = []
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
                        $.each(data, function (index, item) {
                            var sku = $(`#sku_${item.sku}`).attr("data-sku");
                            i = 1;
                            if(sku == item.sku){
                                i = parseInt($(`#sku_${item.sku}`).find(`.quantity_${item.sku}`).text());
                                i++;
                            $(`#sku_${item.sku}`).find(`.quantity_${item.sku}`).text(i);
                            $(`#sku_${item.sku}`).find(`.quantity-${item.sku}`).val(i);
                            } else {
                                var template =
                                    `<tr class="items_row" id="sku_${item.sku}" data-sku="${item.sku}">
                                        <td class="product_${item.sku}">${item.product.name}</td>
                                        <td class="variant_${item.sku}">${item.name}</td>
                                        <td class="quantity_${item.sku}">${i}</td>
                                        <td hidden>
                                            <input hidden name="items[${item.id}][variant_id]" value="${item.id}"></input>
                                            <input hidden name="items[${item.id}][product]" value="${item.product.name}"></input>
                                            <input hidden name="items[${item.id}][variant]" value="${item.name}"></input>
                                            <input hidden class="quantity-${item.sku}" name="items[${item.id}][quantity]" value="${i}"></input>
                                        </td>
                                    </tr>`;
                                $("#scan_items").append(template);
                            }
                        });
                        $('.items_row').each(function () {
                            var productName = $('td[data-product]').attr('data-product');
                            var variantName = $('td[data-variant]').attr('data-variant');
                            var quantitycount = $('td[data-quantity]').attr('data-quantity');

                            var sku = $(this).attr("data-sku");
                            var product = $(this).find('.product_' + sku).text();
                            var variant = $(this).find('.variant_' + sku).text();
                            var quantity = $(this).find('.quantity_' + sku).text();
                            if (productName == product) {
                                $(this).find('.product_' + sku).css({backgroundColor: '#46b346',color: 'white'});
                            } else {
                                $(this).find('.product_' + sku).css({backgroundColor: '#d93737',color: 'white'});
                            }
                            if (variantName == variant) {
                                $(this).find('.variant_' + sku).css({backgroundColor: '#46b346',color: 'white'});
                            } else {
                                $(this).find('.variant_' + sku).css({backgroundColor: '#d93737',color: 'white'});
                            }
                            if (quantitycount == quantity) {
                                $(this).find('.quantity_' + sku).css({backgroundColor: '#46b346',color: 'white'});
                            } else {
                                $(this).find('.quantity_' + sku).css({backgroundColor: '#d93737',color: 'white'});
                            }
                        });
                    }
            });
        }
    });
    $(document).ready(function() {

    });

</script>
@endsection
