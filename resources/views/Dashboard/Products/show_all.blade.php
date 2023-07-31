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
            <li><a class="link-dark" href="{{ route('all_products') }}">المنتجات</a></li>
        </ul>
    </div>
    <div class="row card p-2 shadow-sm">
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th scope="col">صورة المنتج</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">المورد</th>
                    <th scope="col">التصنيف</th>
                    <th scope="col">الماركة</th>
                    <th scope="col">السعر</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="">
                        <td><div class="product-main" style="background-image: url('{{asset($product->main_image->path ?? '')}}')"></div></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->supplier->name }}</td>
                        <td>{{ $product->category->parents_names }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            @can('edit','App\Models\Supplier')
                                <a  href="{{route('show_product',$product->id)}}" class="link-primary"
                                    title="مشاهدة المنتج">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a  href="{{route('edit_product',$product->id)}}" class="link-primary"
                                    title="تعديل المنتج">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <div dir="ltr" class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection