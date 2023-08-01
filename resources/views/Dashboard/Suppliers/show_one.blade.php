@extends('layouts.app')
@section('content')

<style>
    .product-main{
        width: 60px;
        height: 60px;
        -webkit-border-radius: 60px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 50px;
        -moz-background-clip: padding;
        border-radius: 50px;
        background-clip: padding-box;
        margin: 7px 0 0 5px;
        float: left;
        background-size: contain;
        background-position: center center;
    }
</style>

<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_suppliers') }}">الموردين</a></li>
            <li><a >{{$data['supplier']->name}}</a></li>
        </ul>
    </div>
    <div class="card fs-5 p-3 row mb-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center"> 
            <div class="fs-2">
                المورد : <span class="badge  bg-success">{{$data['supplier']->name}}</span>
            </div>
        </div>
    </div>
    <div class="row card p-2 shadow-sm">
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th scope="col">صورة المنتج</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">الماركة</th>
                    <th scope="col">التصنيف</th>
                    <th scope="col">السعر</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['products'] as $product)
                    <tr class="">
                        <td><div class="product-main" style="background-image: url('{{asset($product->main_image->path ?? '')}}')"></div></td>
                        <td><a  href="{{route('show_product',$product->id)}}" class="link-primary"
                            title="مشاهدة المنتج">{{ $product->name }}</a></td>
                            <td><a href="{{ route('show_brand',$product->brand_id) }}">{{ $product->brand->name }}</a></td>
                            <td><a href="{{ route('show_category',$product->category_id) }}">{{ $product->category->parents_names }}</a></td>
                            <td>{{ $product->price }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <div dir="ltr" class="d-flex justify-content-center">
            {!! $data['products']->links() !!}
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection