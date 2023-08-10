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

        <div class="card shadow-sm p-3" >
            <form method="GET" action="{{route('all_products')}}" id="search">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control product_info @error('name') is-invalid @enderror"
                            name="name" value="{{Request::get('name')}}">

                        <div class="invalid-feedback name">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ماركة المنتج</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="brand_id" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار الماركة</option>
                            @foreach ($data['brands'] as $id => $name)
                                <option @if(Request::get('brand_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback brand_id">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المورد </label>
                        <select class="form-select product_info" aria-label="Default select example" name="supplier_id">
                            <option value="">اختار المورد</option>
                            @foreach ($data['suppliers'] as $id => $name)
                                <option  @if(Request::get('supplier_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback supplier_id">

                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">تصنيف</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="category_id"
                            id="category_id">
                            <option value="">اختار تصنيف </option>
                            @foreach ($data['categories'] as $cat)
                                <option @if(Request::get('category_id') == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->parents_names }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback category_id">

                        </div>
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        @if($data['filters'])
        <div class="card shadow-sm p-3 mt-2">
            <div class="d-flex justify-content-start">
                @foreach ($data['filters'] as $key => $value)
                    <div class=" sidebar-bg p-2 m-1" style="color: white">
                        {{__($key)}}: {{$value}}
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-3">
            <div class="card p-3" style="background: #fff;">
                <div class="row row-cols-5">
                    @foreach ($products as $product)
                        <div class="mt-3 col">
                            <div class="card border-0 shadow card-hover @isset($product->images[0]) has-second @endisset text-black" style="transition:all 0.3s ease-in-out">
                                <a href="{{route('show_product',$product->id)}}">
                                    <img src="{{ asset($product->main_image->path ?? '') }}" class="card-img-top" style="object-fit: contain;height: 15vw;"  onerror="this.src = 'https://placehold.co/400?text=no+image'" @isset($product->images[0]) onerror="this.src = '{{asset($product->images[0] ?? '')}}'" @endisset />
                                    
                                    @isset($product->images[0])
                                        <img src="{{ asset($product->images[0]->path ?? '') }}" class="card-img-top" style="object-fit: contain;height: 15vw;display:none;" onerror="this.src = 'https://placehold.co/400?text=no+image'" />
                                    @endisset
                                </a>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5 class="card-title m-0" style="overflow: auto;text-overflow: ellipsis;overflow-y: hidden;overflow-x: hidden;white-space: nowrap;"><a
                                            class="text-break link-dark" 
                                                href="{{ route('show_product', $product->id) }}">{{ $product->name }}</a></h5>
                                        <p class="text-muted mb-2"><a class="text-break link-dark" 
                                                href="{{ route('show_brand', $product->brand_id) }}">{{ $product->brand->name }}</a>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <span>المورد</span><span><a class=""
                                                    href="{{ route('show_supplier', $product->supplier_id) }}">{{ $product->supplier->name }}</a></span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-s">
                                            <span>التصنيف</span><span><a class=""
                                                    href="{{ route('show_category', $product->category_id) }}">{{ $product->category->name }}</a></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between total font-weight-bold mt-2">
                                        <span>السعر</span><span>{{ $product->price }} </span>
                                    </div>
                                    @can('edit','App\Models\Product')
                                        <a class="btn btn-primary d-block mt-2" href="{{route('edit_product',$product->id)}}"> 
                                            تعديل <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div dir="ltr" class="d-flex justify-content-center mt-5">
                    {!! $products->appends($_GET)->links() !!}
                </div>
        </div>

            

            
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

        $(document).ready(function() {
            $('select.product_info').select2({
                padding: 'resolve',
            });
        })

    function swapImg($container) {
        var $image = $container.find('img:visible');
        var $image2 = $image.siblings();
        $image.stop().fadeOut(function(){
            $image2.stop().fadeIn();
        });
    }
    $('.has-second').hover(function () {
        swapImg($(this));
        
    }, function () {
        swapImg($(this));
    });
    $('.card-hover').hover(function () {
        $(this).addClass("shadow-sm");
    }, function () {
        $(this).removeClass("shadow-sm");
    });

    $("#search").submit(function (e) {
        e.preventDefault();
        const query = {};
        $("#search input, #search select").each(function () {
            if($(this).val()){
                query[$(this).attr('name')] = $(this).val();
            }
        })
        let params = new URLSearchParams(query);
        window.location.search = params.toString();
    })

</script>
@endsection
