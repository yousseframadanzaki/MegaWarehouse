@extends('layouts.app')
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

<div class="p-3">

<div class="row">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li><a href="{{ route('all_products') }}">المنتجات</a></li>
        <li><a class="link-dark" ">{{$product->name}}</a></li>
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
            <div class="table-responsive">
                <table class="table  table-hover fs-5" style="min-width: 700px;">
                    <thead>
                        <tr>
                            <th scope="col">اسم</th>
                            <th scope="col">السعر</th>
                            @if ($product->is_bundle == 0)<th scope="col">الكمية</th>@endif
                            <th scope="col">sku</th>
                            @if ($product->is_bundle == 0)<th scope="col">رقم الرف</th>@endif
                            <th scope="col">طباعة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (($product->is_bundle == 0) ? $product->variants : $product->bundle_variants as $variant)
                            <tr class="">
                                <td>{{ $variant->name }}</td>
                                <td>{{ ($product->is_bundle == 0) ? $variant->price : $variant->pivot->price }}</td>
                                @if ($product->is_bundle == 0)<td><a class="link-primary" style="cursor: pointer" data-id="{{$variant->id}}" data-bs-toggle="modal" data-bs-target="#quantities" >{{ $variant->total_stock_quantity }}</a></td>@endif
                                <td>{{ $variant->sku }}</td>
                                @if ($product->is_bundle == 0)<td>{{ $variant->shelf_num }}</td>@endif
                                <td><a href="{{route('print_variant',$variant->id)}}" target="_blank"><i class="bi bi-printer-fill"></i></a></td>
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

$("#quantities").on('show.bs.modal',function (e) {
    var id = $(e.relatedTarget).attr('data-id');

    $.ajax({
        url:`/api/variants/${id}/stock`,
        method:"GET",
        dataType: "text",
    }).then(response => {
        data = JSON.parse(response);
        // console.log(data);
        add_data(data);
    })
})

function add_data(data) {
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

</script>

@endsection
