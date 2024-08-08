@extends('layouts.store_app')

@section('content')
    <style>
        .card-custom {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            transition: background-color 0.3s ease-in-out;
            z-index: 1;
        }
        .card-custom:hover .card-image {
            transform: scale(1.1);
        }
        .card-custom:hover .card-overlay {
            background-color: rgba(0, 0, 0, 0.6);
        }
        .category-name {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            z-index: 2;
            padding: 0 15px;
        }
    </style>

    <div class="container">
        <div class="row g-4">
            <div class="col-12">
                <h3 class="text-center mt-2"> الأصناف الأكثر شيوعا </h3>
                <p class="text-center my-2">كل صنف يحتوي علي العديد من المنتجات المتنوعة و الرائعة</p>
            </div>
            @foreach ($categories->take(8) as $category)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card-custom">
                        <img src="https://via.placeholder.com/250x250" alt="Category Image 1" class="card-image">
                        <div class="card-overlay"></div>
                        <div class="category-name">{{ $category->name }}</div>
                    </div>
                </div>
            @endforeach
            @if ($categories->count() > 8)
                <div class="col-12">
                    <div class="text-center mt-2">
                        <a href="" class="btn btn-primary">عرض المزيد من التصنيفات</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    {{-- when page load scripts --}}
    <script>
        $(document).ready(function() {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            cart.forEach(variant_id => {
                $(`.addCart[data-id=${variant_id}]`).addClass('bg-success').text('تم الاضافة للأوردر بنجاح');
            });
        })
    </script>
    {{-- end page load scripts --}}

    {{-- products scripts --}}
    <script>
        let nextPage = 2;
        let isLoading = false;

        window.addEventListener('scroll', function() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight && !isLoading) {
                loadMorevariants();
            }
        });

        function loadMorevariants() {
            if (isLoading || nextPage === null) return;
            isLoading = true;
            $('#loader').show();

            fetch(`/api/get_all_variants?page=${nextPage}`)
            .then(response => response.json())
            .then(data => {
                $('#loader').hide();
                data.variants.forEach(variant => {
                    let template = `
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                            <div class="card shadow">
                                <img src="https://images.unsplash.com/photo-1576158113928-4c240eaaf360?q=80&w=1480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top w-100" style="height: 250px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-center"> <span class="fw-bold">${ (variant.product) ? variant.product.name : '' }</span> <hr class="my-2"> <span>${ variant.name }</span></h5>
                                    <div class="d-flex justify-content-between">
                                        <p class="my-1">الماركة</p>
                                        <p class="my-1 text-primary">${ (variant.product.brand) ? variant.product.brand.name : '' }</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="my-1">التصنيف</p>
                                        <p class="my-1 text-primary">${ (variant.product.category) ? variant.product.category.name : '' }</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="my-1">السعر</p>
                                        <p class="my-1 text-primary">${ variant.product.price }</p>
                                    </div>
                                    <hr>
                                    <button class="btn btn-primary w-100 addCart" data-id="${ variant.id }">إضافة إلي العربة <i class="bi bi-cart-fill"></i></button>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#variantContainer').append(template);
                });

                nextPage = data.nextPage;
                isLoading = false;
            })
            .catch(() => {
                isLoading = false;
            });
        }
    </script>
    {{-- end products scripts --}}

    {{-- order scripts --}}
    <script>
        $(document).on('click', '.addCart', function() {
            if (!$(this).hasClass('bg-success')) {
                let variant_id = $(this).data('id');
                let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

                cart.push(variant_id);
                sessionStorage.setItem('cart', JSON.stringify(cart));

                $(this).addClass('bg-success');
                $(this).text('تم الاضافة للأوردر بنجاح');

                let cartCount = JSON.parse(sessionStorage.getItem('cartCount')) || 0;
                cartCount++;
                sessionStorage.setItem('cartCount', cartCount);

                $('#cartCount').show().text(cartCount);
                console.log(cart);
            }
        })
    </script>
    {{-- end order scripts --}}
@endsection
