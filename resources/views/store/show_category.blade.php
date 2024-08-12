@extends('layouts.store_app')

@section('content')
    <div class="modal fade" id="showProductModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center" style="font-size: 20px" id="showProductTitle">خيارات منتج <span class="fw-bold"></span></p>
                    <hr class="my-3">
                    <div id="loader" class="text-danger text-center my-3">
                        <h4>جاري التحميل ...</h4>
                    </div>
                    <div class="row justify-content-center" id="variants">
                    </div>
                </div>
                <div class="modal-footer text-center d-block">
                    <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">اغلاق</button>
                    {{-- <button type="button" class="btn btn-primary add_to_cart_btn">إضافة</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mt-3 mb-4"> منتجات الصنف <span class="fw-bold">( {{ $category->name }} )</span> </h3>
            </div>
            @php $hasProducts = 0; @endphp
            @foreach ($category->products as $product)
                @if ($product->variants->isNotEmpty())
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card shadow">
                            <img src="https://images.unsplash.com/photo-1576158113928-4c240eaaf360?q=80&w=1480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top w-100" style="height: 250px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center"> <span class="fw-bold">{{ $product->name }}</span> <hr class="my-2"></h5>
                                <div class="d-flex justify-content-between">
                                    <p class="my-1 fw-bold">السعر</p>
                                    <p class="my-1">
                                        @if (!empty($product->before_sale_price))
                                            <span style="text-decoration: line-through" class="text-danger d-inline-block mx-2">{{ $product->before_sale_price }}</span>
                                        @endif
                                        <span>{{ $product->price }}</span>
                                    </p>
                                </div>
                                <hr>
                                <button class="btn btn-primary w-100" data-bs-target="#showProductModal" data-bs-toggle="modal" data-id="{{ $product->id }}" data-name="{{ $product->name }}"> عرض خيارات المنتج </button>
                            </div>
                        </div>
                    </div>
                    @php
                        $hasProducts = 1;
                    @endphp
                @endif
            @endforeach
            @if ($hasProducts == 0)
                <h5 class="text-danger text-center">لا يوجد منتجات لهذا الصنف حاليا.</h5>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        let old_product_id = 0;
        $('#showProductModal').on('show.bs.modal', function(e) {
            let product_id = $(e.relatedTarget).attr('data-id');
            let product_name = $(e.relatedTarget).attr('data-name');
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

            if (product_id != old_product_id) {
                old_product_id = product_id;

                $('#showProductTitle span').text(`( ${product_name} )`);
                $('#variants').html('');
                $('#loader').show();

                $.ajax({
                    type: 'GET',
                    url: `/api/product/${product_id}/variants`,
                    dataType: "text",
                }).then((response) => {
                    data = JSON.parse(response);

                    $('#loader').hide();
                    $.each(data, function(index, variant) {
                        if (variant.quantity > 0) {
                            const exists = cart.some(item => item.id == variant.id);

                            template = `
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                    <div class="card shadow">
                                        <img src="https://images.unsplash.com/photo-1576158113928-4c240eaaf360?q=80&w=1480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top w-100" style="height: 250px;" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"> <span class="fw-bold">${ variant.name }</span> <hr class="my-2"></h5>
                                            ${ !exists ? `
                                                <div class="quantity-box">
                                                    <div class="d-flex">
                                                        <p class="my-1" style="flex: 1;">الكمية</p>
                                                        <input type="number" class="form-control quantity border-secondary" min="1" style="flex: 1;">
                                                    </div>
                                                    <hr class="my-2">
                                                </div>
                                                <button class="btn btn-primary w-100 addCart" data-id="${ variant.id }">إضافة إلي العربة <i class="bi bi-cart-fill"></i></button>
                                            ` : `<button class="btn btn-primary bg-success w-100 addCart">تم الاضافة للأوردر بنجاح</button>` }
                                        </div>
                                    </div>
                                </div>
                            `;

                            $("#variants").append(template);
                        }
                    });
                });
            } else {
                $('#loader').hide();
            }
        })
    </script>

    {{-- order scripts --}}
    <script>
        $(document).on('click', '.addCart', function() {
            if (!$(this).hasClass('bg-success')) {
                let variant_id = $(this).data('id');
                let quantity = $(this).closest('.card-body').find('.quantity').val();
                if (quantity <= 0 || quantity == '')
                    return;

                let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

                cart.push({id: variant_id, quantity: quantity});
                sessionStorage.setItem('cart', JSON.stringify(cart));

                $(this).closest('.card-body').find('.quantity-box').hide();
                $(this).addClass('bg-success');
                $(this).text('تم الاضافة للأوردر بنجاح');

                let cartCount = JSON.parse(sessionStorage.getItem('cartCount')) || 0;
                cartCount++;
                sessionStorage.setItem('cartCount', cartCount);

                $('#cartCount').show().text(cartCount);
            }
        })
    </script>
    {{-- end order scripts --}}
@endsection
