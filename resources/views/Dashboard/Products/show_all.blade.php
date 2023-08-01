@extends('layouts.app')
@section('content')
    <style>
        .product-main {
            width: 70px;
            height: 70px;
            -webkit-border-radius: 60px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 50px;
            -moz-background-clip: padding;
            border-radius: 50px;
            background-clip: padding-box;
            margin: 7px 0 0 5px;
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
        <div class="p-2">
            <div class="row">
            @foreach ($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card @isset($product->images[0]) has-second @endisset text-black">
                    <img src="{{ asset($product->main_image->path ?? '') }}" class="card-img-top" style="object-fit: contain;height: 20vw;" @isset($product->images[0]) onerror="this.src = 'https://placehold.co/400?text=no+image'" onerror="this.src = '{{asset($product->images[0] ?? '')}}'" @endisset />
                    
                    @isset($product->images[0])
                        <img src="{{ asset($product->images[0]->path ?? '') }}" class="card-img-top" style="object-fit: contain;height: 20vw;display:none;" onerror="this.src = 'https://placehold.co/400?text=no+image'" />
                    @endisset
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title m-0"><a
                                    href="{{ route('show_product', $product->id) }}">{{ $product->name }}</a></h5>
                            <p class="text-muted mb-2"><a class="" 
                                    href="{{ route('show_brand', $product->brand_id) }}">{{ $product->brand->name }}</a>
                            </p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between">
                                <span>المورد</span><span><a class=""
                                        href="{{ route('show_supplier', $product->supplier_id) }}">{{ $product->supplier->name }}</a></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>التصنيف</span><span><a class=""
                                        href="{{ route('show_category', $product->category_id) }}">{{ $product->category->parents_names }}</a></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between total font-weight-bold mt-2">
                            <span>السعر</span><span>{{ $product->price }} </span>
                        </div>
                        <a class="btn btn-primary d-block mt-2" href="{{route('edit_product',$product->id)}}"> تعديل <i class="bi bi-pencil-square"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

            

            <div dir="ltr" class="d-flex justify-content-center">
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function swapImg($container) {
        var $image = $container.find('img:visible');
        var $image2 = $image.siblings();
        $image.stop().fadeOut(function(){
            $image2.stop().fadeIn();
        });
    }
    $('.has-second').hover(function () {
        swapImg($(this));
        $(this).addClass("shadow");
    }, function () {
        swapImg($(this));
        $(this).removeClass("shadow");
    });
    $('.card').hover(function () {
        $(this).addClass("shadow");
    }, function () {
        $(this).removeClass("shadow");
    });
</script>
@endsection
