@extends('layouts.app')

@section('title')
    {{ __('products_title') }}
@endsection

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

        label {
            font-weight: bold;
        }
    </style>

    <div id="message" style="display: none">

    </div>

    <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="cart_form" method="POST">
                        @csrf
                        <div class="row">
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
                                    @foreach ($data['warehouses'] as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">الكمية</label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="col-md-12 mt-4">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary add_to_cart_btn">إضافة</button>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_products') }}">المنتجات</a></li>
            </ul>
        </div>

        <div class="card shadow-sm p-3">
            <form method="GET" action="{{ route('all_products') }}" id="search">
                <div class="row">
                    <div class="col-md-4 col-lg-3 mt-4">
                        <label class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control product_info @error('name') is-invalid @enderror"
                            name="name" value="{{ Request::get('name') }}">

                        <div class="invalid-feedback name">

                        </div>

                    </div>
                    <div class="col-md-4 col-lg-3 mt-4">
                        <label class="form-label">ماركة المنتج</label>
                        <select class="form-control product_info w-100" aria-label="Default  select example" name="brand_id"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار الماركة</option>
                            @foreach ($data['brands'] as $id => $name)
                                <option @if (Request::get('brand_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback brand_id">

                        </div>

                    </div>
                    <div class="col-md-4 col-lg-3 mt-4">
                        <label class="form-label">المورد </label>
                        <select class="form-control product_info w-100" aria-label="Default select example" name="supplier_id">
                            <option value="">اختار المورد</option>
                            @foreach ($data['suppliers'] as $id => $name)
                                <option @if (Request::get('supplier_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback supplier_id">

                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 mt-4">
                        <label class="form-label">تصنيف</label>
                        <select class="form-control product_info w-100" aria-label="Default  select example" name="category_id"
                            id="category_id">
                            <option value="">اختار تصنيف </option>
                            @foreach ($data['categories'] as $cat)
                                <option @if (Request::get('category_id') == $cat->id) selected @endif value="{{ $cat->id }}">
                                    {{ $cat->parents_names }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback category_id">

                        </div>
                    </div>
                    <div class="col-12 my-4">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                بحث
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($data['filters'])
            <div class="card shadow-sm p-3 mt-2">
                <div class="row">
                    @foreach ($data['filters'] as $key => $value)
                        <div class="col-md-4 col-lg-3">
                            <div class=" sidebar-bg p-2 m-1" style="color: white">
                                {{ __($key) }}: {{ $value }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-3">
            <div class="card p-3" style="background: #fff;">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="mt-4 col-sm-6 col-md-4 col-lg-3 product-container">
                            <div class="card border-secondary shadow card-hover @isset($product->images[1]) has-second @endisset text-black"
                                style="transition:all 0.3s ease-in-out">
                                <a href="{{ route('show_product', $product->id) }}">
                                    <img src="{{ asset($product->images[0]->path ?? '') }}" class="card-img-top"
                                        style="object-fit: contain;height: 15vw;"
                                        @isset($product->images[1]) onerror="this.src = '{{ asset($product->images[1]->path ?? '') }}'" @endisset />

                                    @isset($product->images[1])
                                        <img src="{{ asset($product->images[1]->path ?? '') }}" class="card-img-top"
                                            style="object-fit: contain;height: 15vw;display:none;"
                                            onerror="this.src = 'https://placehold.co/400?text=no+image'" />
                                    @endisset
                                </a>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5 class="card-title m-0"
                                            style="overflow: auto;text-overflow: ellipsis;overflow-y: hidden;overflow-x: hidden;white-space: nowrap;">
                                            <a class="text-break link-dark"
                                                href="{{ route('show_product', $product->id) }}">{{ $product->name }}</a>
                                        </h5>
                                        @if ($product->is_bundle == 0)
                                            <a class="text-break my-2 d-inline-block"
                                                href="{{ route('show_brand', $product->brand_id) }}">{{ $product->brand->name }}</a>
                                        @else
                                            <div style="height: 70px"></div>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($product->is_bundle == 0)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>المورد</span><span><a class=""
                                                        href="{{ route('show_supplier', $product->supplier_id) }}">{{ $product->supplier->name }}</a></span>
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between" style="font-s">
                                            <span>التصنيف</span><span><a class=""
                                                    href="{{ route('show_category', $product->category_id) }}">{{ $product->category->name }}</a></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between total font-weight-bold my-2">
                                        <span>السعر</span><span>{{ $product->price }} </span>
                                    </div>
                                    @can('edit', 'App\Models\Product')
                                        <div class="d-flex flex-row justify-content-around">
                                            @if ($product->is_bundle == 0)
                                                <a class="btn btn-primary d-block mt-2 border-0" title="تعديل المنتج"
                                                    style="width:48%" href="{{ route('edit_product', $product->id) }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-dark text-white d-block mt-2 border-0" title="باكيدج"
                                                    style="width:48%; cursor: context-menu;">
                                                    باكيدج
                                                    <i class="bi bi-bag"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-primary d-block mt-2 border-0" title="إضافة الى عربة"
                                               @can('delete_product', 'App\Models\Product') style="width:23%;" @else style="width:48%;" @endcan data-id="{{ $product->id }}" data-bs-toggle="modal"
                                                data-bs-target="#addToCartModal">
                                                <i class="bi bi-cart-plus"></i>
                                            </a>
                                            @can('delete_product', 'App\Models\Product')
                                            <a class="btn-delete btn btn-danger d-block mt-2 border-0" title="حذف المنتج"
                                                style="width:23%;" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            @endcan
                                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('select.product_info').select2({
                padding: 'resolve',
                width: 'resolve',
            });
        })

        function swapImg($container) {
            var $image = $container.find('img:visible');
            var $image2 = $image.siblings();
            $image.stop().fadeOut(function() {
                $image2.stop().fadeIn();
            });
        }
        $('.has-second').hover(function() {
            swapImg($(this));

        }, function() {
            swapImg($(this));
        });
        $('.card-hover').hover(function() {
            $(this).addClass("shadow-sm");
        }, function() {
            $(this).removeClass("shadow-sm");
        });

        $("#search").submit(function(e) {
            e.preventDefault();
            const query = {};
            $("#search input, #search select").each(function() {
                if ($(this).val()) {
                    query[$(this).attr('name')] = $(this).val();
                }
            })
            let params = new URLSearchParams(query);
            window.location.search = params.toString();
        })

        $("#addToCartModal").on('show.bs.modal', function(e) {
            var product_id = $(e.relatedTarget).attr('data-id');
            $("#variant_id").html("");
            $("#stock").html("");
            $("#quantity").val("");
            $("#warehouse_id").val("");
            $.ajax({
                url: `/api/product/${product_id}/variants`,
                method: `GET`,
                dataType: 'text'
            }).then(response => {
                data = JSON.parse(response);
                $("#variant_id").append(`<option value="">اختار المتغير</option>`)
                data.forEach(element => {

                    $("#variant_id").append(
                        `<option value="${element.id}">${element.name}</option>`)
                })
                $('#variant_id').select2({
                    dropdownParent: $('#addToCartModal')
                });
                $('#warehouse_id').select2({
                    dropdownParent: $('#addToCartModal')
                });
            })
        })

        $('#variant_id').change(function() {
            var variant_id = $(this).val();

            $.ajax({
                url: `/api/variants/${variant_id}/stock`,
                method: "GET",
                dataType: "text",
            }).then(response => {
                data = JSON.parse(response);
                add_stock(data);
            })
        })

        $(".add_to_cart_btn").click(function(e) {
            e.preventDefault();
            var variant_id = $('#variant_id').val();
            var warehouse_id = $('#warehouse_id').val();
            var quantity = $('#quantity').val();

            if (!variant_id) {
                alert('برجاء اختيار المتغير');
                return;
            }
            if (!warehouse_id) {
                alert('برجاء اختيار المخزن');
                return;
            }
            if (!quantity) {
                alert('برجاء اختيار الكمية');
                return;
            }

            const item = {
                variant_id,
                warehouse_id,
                quantity
            };

            $.ajax({
                url:'/api/cart/add',
                method:'POST',
                data:item,
                dataType:'json'
            }).then(data =>{

                    if(data){
                        $("#addToCartModal").modal('hide');
                        window.location = '{!! route('add_order') !!}'
                    }

            })
            // $("#cart_form").submit();


        })

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

        function add_stock(data) {
            $("#stock").html("");
            data.forEach(element => {
                if (element.sum != "0") {
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

        $('.btn-delete').click(function() {
            product_name = $(this).attr('data-name');
            if (confirm(`هل أنت متأكد من حذف المنتج ( ${product_name} ) ؟`)) {
                product_id = $(this).attr('data-id');
                product_container = $(this).closest('.product-container');
                product_container.find('.card').hide();
                product_container.append('<p class="h-100 d-flex justify-content-center align-items-center text-danger fw-bold">جاري الحذف ...</p>');

                $.ajax({
                    url: `/api/product/${product_id}/delete`,
                    method: 'POST',
                    data: {
                        product_id,
                        _token: '@csrf'
                    },
                    success: function (response) {
                        product_container.remove();
                        setTimeout(() => {
                            alert('تم حذف المنتج بنجاح');
                        }, 500);
                    }
                })
            }
        })
    </script>
@endsection
