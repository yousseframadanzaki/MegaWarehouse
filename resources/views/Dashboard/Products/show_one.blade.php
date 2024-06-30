@extends('layouts.app')

@section('title')
    {{ ($product->is_bundle == 0) ? __('show_product_title') : __('show_package_title') }}
@endsection

@section('content')

<style>
    /* .main_image{
        object-fit: contain;
        height: 15vw;
        padding: 0;
    } */
    .small-image{
        width: 50px;
        height:50px;
        border: solid 0.5px #000;
        margin: 5px;
        margin-right: 0;
        background-size:contain;
        background-clip:padding-box;
        background-repeat: no-repeat;
        background-position: center center;
    }
    .small-image:hover{
        border: solid 2px var(--bs-primary);
    }

</style>


<div class="modal fade" id="quantities" tabindex="-1" aria-labelledby="quantitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center">
                <h5 class="mb-3 fw-bold title"></h5>
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

<div class="modal fade" id="shelfData" tabindex="-1" aria-labelledby="shelfDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center">
                <h5 class="mb-3 fw-bold title"></h5>
                <table class="table hover-table">
                    <thead>
                        <tr>
                            <th>اسم المخزن</th>
                            <th>رقم الرف</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editVariant" tabindex="-1" aria-labelledby="EditVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="mb-3 fw-bold title text-center"></h5>
                <form action="{{ route('variant.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="variant_id" id="variant_id">
                    <div class="form-group mb-3">
                        <label class="fw-bold mb-2">اسم المتغير</label>
                        <input type="text" class="form-control" name="name" id="variant_name" placeholder="اسم المتغير">
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-bold mb-2">السعر</label>
                        <input type="number" class="form-control" name="price" id="variant_price" placeholder="السعر">
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-bold mb-2">SKU</label>
                        <input type="text" class="form-control" name="sku" id="variant_sku" placeholder="SKU">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                        <p class="error-message text-danger mt-3 mb-0" style="display: none;">هناك بعض الحقول فارغة</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="p-3">

<div class="row">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li><a href="{{ route('all_products') }}">المنتجات</a></li>
        <li><a class="link-dark">{{$product->name}}</a></li>
    </ul>
</div>

<div class="card p-2 shadow-sm">
    <div class="row">
        <div class="images-container col-md-3">
            @isset($product->images)
                <div>
                    <img src="{{ asset($product->images[0]->path ?? '') }}" class="card-img-top main_image"
                                            style="object-fit: contain;height:50vh;"
                                            onerror="this.src = 'https://placehold.co/400?text=no+image'" />
                    {{-- <div class="main_image" style="background-image:url('{{asset($product->images[0]->path ?? "")}}')"> </div> --}}
                </div>
                <div class="row ">
                    @foreach ($product->images as $image)
                            <img src="{{ asset($image->path ?? '') }}" class="card-img-top small-image"
                                style="object-fit: contain;"
                                onerror="this.src = 'https://placehold.co/400?text=no+image'" />
                        {{-- <div style="background-image:url({{asset($image->path ?? "")}})" class="small-image col-md-4"> </div> --}}
                    @endforeach
                </div>
            @endisset
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center my-4">
                <div class="badge p-2 mb-2" style="background: rgb(8 47 73)"><h1 class="m-0 p-0">{{$product->name}}</h1></div>
                @if ($product->is_bundle == 0)
                    @can('edit','App\\Models\Product')
                        <div>
                            <a class="btn btn-primary" href="{{route('edit_product',$product->id)}}"> <i class="bi bi-pencil-square"></i> تعديل </a>
                        </div>
                    @endcan
                @else
                    <a class="btn btn-dark" style="cursor: context-menu;"> باكيدج <i class="bi bi-bag"></i> </a>
                @endif
            </div>
            <div class="row">
                <div class="col-md-3 fs-5 mb-2"><span style="font-weight: 600;">السعر: </span><span>{{$product->price}}</span></div>
                <div class="col-md-3 fs-5 mb-2"><span style="font-weight: 600;">السعر قبل الخصم : </span><span>{{$product->before_sale_price}}</span></div>
                @if(!empty($product->brand_id))<div class="col-md-3 fs-5 mb-2"><span style="font-weight: 600;">الماركة : </span><span><a href="{{ route('show_brand',$product->brand_id) }}">{{$product->brand->name ?? ''}}</a></span></div>@endif
                @if(!empty($product->supplier_id))<div class="col-md-3 fs-5 mb-2"><span style="font-weight: 600;">المورد : </span><span><a href="{{ route('show_supplier',$product->supplier_id) }}">{{$product->supplier->name ?? ''}}</a></span></div>@endif
                @if(!empty($product->category_id))<div class="col-md-12 fs-5 mb-2"><span style="font-weight: 600;">التصنيف : </span><span><a href="{{ route('show_category',$product->category_id) }}">{{$product->category->parents_names ?? ''}}</a></span></div>@endif
            </div>
            <div class="row mt-2">
                @foreach ($attributes as $name => $attribute)
                    <div class="col-md-4">
                        <span style="font-weight: 600;">{{$name}}</span>
                        <br>
                        @foreach ($attribute['values'] as $value)
                            <div class="badge p-2 bg-success my-2">
                                {{ $value }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="fs-5 mt-3">
                <span style="font-weight: 600;" class="mb-3">وصف المنتج</span>
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3 p-2 shadow-sm">
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <form method="GET" target="_blank" action="{{route('print_bulk_variants', $product->id)}}" id="print_label">
                    <div class="btn btn-primary print_label"> طباعة <i class="bi bi-printer"></i></div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table  table-hover fs-5" style="min-width: 700px;">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="form-check-input" name="" id="check_all"></th>
                            <th scope="col">اسم المتغير</th>
                            <th scope="col">السعر</th>
                            @if ($product->is_bundle == 0)<th scope="col">الكمية</th>@endif
                            <th scope="col">sku</th>
                            @if ($product->is_bundle == 0)<th scope="col">رقم الرف</th>@endif
                            @canany(['delete_variant'], 'App\Models\Product')
                            <th scope="col">إجراءات</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (($product->is_bundle == 0) ? $product->variants : $product->bundle_variants as $variant)
                            <tr class="">
                                <td><input type="checkbox" class="variant_id form-check-input" value="{{$variant->id}}"></td>
                                <td>{{ $variant->name }}</td>
                                <td>{{ ($product->is_bundle == 0) ? $variant->price : $variant->pivot->price }}</td>
                                @if ($product->is_bundle == 0)<td><a class="link-primary" style="cursor: pointer" data-id="{{$variant->id}}" data-name={{$variant->name}} data-bs-toggle="modal" data-bs-target="#quantities" >{{ $variant->total_stock_quantity }}</a></td>@endif
                                <td>{{ $variant->sku }}</td>
                                @if ($product->is_bundle == 0)<td>@if(!empty($variant->shelf_num))<a href="" class="shelf_data_link" data-shelf_num="{{ $variant->shelf_num }}" data-name={{$variant->name}} data-bs-toggle="modal" data-bs-target="#shelfData">عرض الرف</a>@endif</td>@endif
                                <td>
                                    <a title="طباعة" class="ms-3" href="{{route('print_variant',$variant->id)}}" target="_blank"><i class="bi bi-printer-fill"></i></a>
                                    <i title="تعديل متغير" class="btn-edit bi bi-pencil-square text-primary ms-3" style="font-size: 18px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editVariant" data-id="{{ $variant->id }}" data-name="{{ $variant->name }}" data-price="{{ $variant->price }}" data-sku="{{ $variant->sku }}" data-is_bundle="{{ $product->is_bundle }}"></i>
                                    @can('delete_variant', 'App\Models\Product')
                                    <i title="حذف متغير" class="btn-delete bi bi-trash text-danger ms-3" style="font-size: 18px; cursor: pointer;" data-id="{{ $variant->id }}" data-name="{{ $variant->name }}" data-is_bundle="{{ $product->is_bundle }}"></i>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
@section('script')

<script>

$(".small-image").hover(function () {
    var url = $(this).attr('src');
    $(".main_image").attr('src',url);
})

old_id = 0;
$("#quantities").on('show.bs.modal',function (e) {
    var id = $(e.relatedTarget).attr('data-id');
    if (id != old_id) {
        old_id = id;

        $("#stock").html("");
        $("#quantities .title").text($(e.relatedTarget).attr('data-name'));
        $.ajax({
        url:`/api/variants/${id}/stock`,
        method:"GET",
        dataType: "text",
        }).then(response => {
            data = JSON.parse(response);
            // console.log(data);
            add_data(data);
        })
    }
})

function add_data(data) {
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

$("#check_all").click(function () {
    if ($(this).is(":checked"))
        $('.variant_id').prop('checked', true);
    else
        $('.variant_id').prop('checked', false);
})

function get_checked_orders() {
    ids = [];
    $('.variant_id').each(function (index, obj) {
        if (this.checked === true) {
            ids.push(this.value);
        }
    });
    return ids;
}

$('.print_label').click(function(e){
    e.preventDefault();
    var ids = get_checked_orders();

    if(ids.length < 1){
        alert('برجاء اختيار متغير واحد على الاقل');
        return;
    }

    ids.forEach(id => {
        $("#print_label").append(`<input type="hidden" name="ids[]" value="${id}" />`);
    });

    $("#print_label").submit();
});

$('.btn-delete').click(function() {
    variant_name = $(this).attr('data-name');
    is_bundle = $(this).attr('data-is_bundle');

    if (confirm(`هل أنت متأكد من حذف المتغير ( ${variant_name} ) ${ is_bundle == 1 ? 'من الباكيدج' : ''} ؟`)) {
        variant_id = $(this).attr('data-id');
        tr = $(this).closest('tr');

        $.ajax({
            url: `/api/variant/${variant_id}/delete`,
            method: 'POST',
            data: {
                variant_id,
                is_bundle,
                _token: '@csrf'
            },
            success: function (response) {
                console.log(response)
                tr.remove();
                setTimeout(() => {
                    alert(response);
                }, 500);
            }
        })
    }
})

old_shelf_data = '';
$('#shelfData').on('show.bs.modal', function(e) {
    shelf_data = $(e.relatedTarget).attr('data-shelf_num');
    if (shelf_data != old_shelf_data) {
        old_shelf_data = shelf_data;

        tbody = $(this).find('tbody');
        tbody.html(''); // delete previous data from modal.
        $("#shelfData .title").text($(e.relatedTarget).attr('data-name'));

        $.ajax({
            url: '/api/variant/shelf-data',
            method: 'GET',
            data: {
                shelf_data
            },
            success: function(response) {
                $.each(response, function(key, value) {
                    tbody.append(`<tr><td>${key}</td><td>${value}</td></tr>`);
                })
            }
        })
    }
})

$('#editVariant').on('show.bs.modal', function(e) {
    id = $(e.relatedTarget).attr('data-id');
    name = $(e.relatedTarget).attr('data-name');
    price = $(e.relatedTarget).attr('data-price');
    sku = $(e.relatedTarget).attr('data-sku');

    $('#editVariant h5').text(name)
    $('#variant_id').val(id);
    $('#variant_name').val(name);
    $('#variant_price').val(price);
    $('#variant_sku').val(sku);
})

$('#editVariant').on('hidden.bs.modal', function(e) {
    $('.error-message').hide();
    $('#editVariant h5').text('');
    $(this).find('input:not[type=submit]').val('');
    $('.error-message').hide();
})

$('#editVariant form').on('submit', function(e) {
    e.preventDefault();

    name = $('#variant_name').val();
    price = $('#variant_price').val();
    sku = $('#variant_sku').val();

    if (name == "" || price == "" || sku == "")
        $('.error-message').show();
    else {
        $('.error-message').hide();
        this.submit();
    }
})

</script>

@endsection
