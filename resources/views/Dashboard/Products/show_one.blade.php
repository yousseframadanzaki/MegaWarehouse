@extends('layouts.app')
@section('content')

<style>
    .main_image{
        width: 100%;
        height: 200px;
        background-clip:padding-box;
        background-repeat: no-repeat;
        background-position: center right;
        background-size: contain;
        padding: 0;
    }
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

<div class="p-3">

<div class="row">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li><a href="{{ route('all_products') }}">المنتجات</a></li>
        <li><a class="link-dark" ">{{$product->name}}</a></li>
    </ul>
</div>

<div class="row card p-2 shadow-sm">
    <div class="row">
        <div class="images-container col-md-3">
            <div>
                <div class="main_image" style="background-image:url('{{asset($product->main_image->path ?? "")}}')"> </div>
            </div>
            <div class="row ">
                <div class="small-image col-md-4" style="background-image:url('{{asset($product->main_image->path ?? "")}}')"> </div>
                @foreach ($product->images as $image)
                    <div style="background-image:url({{asset($image->path ?? "")}})" class="small-image col-md-4"> </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <div class="badge p-2 mb-2" style="background: rgb(8 47 73)"><h1 class="m-0 p-0">{{$product->name}}</h1></div>
            <div class="row">
                <div class="col-md-3 fs-5"><span style="font-weight: 600;">السعر: </span><span>{{$product->price}}</span></div>
                <div class="col-md-3 fs-5"><span style="font-weight: 600;">السعر قبل الخصم : </span><span>{{$product->before_sale_price}}</span></div>
                <div class="col-md-3 fs-5"><span style="font-weight: 600;">الماركة : </span><span><a href="{{ route('show_brand',$product->brand_id) }}">{{$product->brand->name}}</a></span></div>
                <div class="col-md-3 fs-5"><span style="font-weight: 600;">المورد : </span><span><a href="{{ route('show_supplier',$product->supplier_id) }}">{{$product->supplier->name}}</a></span></div>
                <div class="col-md-12 fs-5"><span style="font-weight: 600;">التصنيف : </span><span><a href="{{ route('show_category',$product->category_id) }}">{{$product->category->parents_names}}</a></span></div>
            </div>
            <div class="row mt-2">
                @foreach ($product->attributes as $attribute)
                    <div class="col-md-4">
                        <span style="font-weight: 600;">{{$attribute->name}}</span>
                        <br>
                        @foreach (json_decode($attribute->values) as $value)
                            <div class="badge p-2 bg-success">{{$value}}</div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="fs-5 mt-3">
                <span style="font-weight: 600;">وصف المنتج</span>
                <p>{{$product->description}}</p>
            </div>
        </div>
    </div>
</div>

<div class="row card mt-3 p-2 shadow-sm">
    <table class="table  table-hover fs-5">
        <thead>
            <tr>
                <th scope="col">اسم</th>
                <th scope="col">السعر</th>
                <th scope="col">الكمية</th>
                <th scope="col">sku</th>
                <th scope="col">طباعة</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($product->variants as $variant)
                <tr class="">
                    <td>{{ $variant->name }}</td>
                    <td>{{ $variant->price }}</td>
                    <td>{{ $variant->quantity }}</td>
                    <td>{{ $variant->sku }}</td>
                    <td><a href="{{route('print_variant',$variant->id)}}" target="_blank"><i class="bi bi-printer-fill"></i></a></td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>

</div>

@endsection
@section('script')

<script>

$(".small-image").hover(function () {
    var url = $(this).css('background-image');
    $(".main_image").css('background-image',url);
})


</script>

@endsection