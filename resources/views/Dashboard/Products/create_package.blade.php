@extends('layouts.app')
@section('content')
<style>
    .hover-danger:hover {
        color: white;
        background: var(--bs-danger);
        border-color: transparent;
    }

    .checkbox {
        position: absolute;
        top: 0%;
        left: 0%;
        z-index: 10;
        width: 20px;
        height: 20px;
    }

    label {
        font-weight: bold;
    }
</style>

<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_products') }}">المنتجات</a></li>
            <li>إضافة باكيدج</li>
        </ul>
    </div>
    <form class="row  " id="product-form" enctype="multipart/form-data" action="{{route('add_package')}}" method="POST">
        @csrf
        <div class="card p-3 shadow-sm">
            <h3 class="text-center">إضافة باكيدج</h3>

                <div class="row">
                    <div class="col-md-4 mt-4">
                        <label class="form-label">اسم الباكيدج <span class="text-danger">*</span></label>
                        <input type="text" class="form-control product_info @error('product_info.name') is-invalid @enderror" name="product_info[name]" value="{{ old('product_info.name') }}">
                        @error('product_info.name')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">السعر <span class="text-danger">*</span></label>
                        <input type="number" class="form-control product_info @error('product_info.price') is-invalid @enderror" name="product_info[price]" value="{{ old('product_info.price') }}">

                        @error('product_info.price')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                        @enderror

                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label">عمولة المسوق</label>
                        <input type="number" class="form-control @error('product_info.marketer_commission') is-invalid @enderror" name="product_info[marketer_commission]">
                        @error('product_info.marketer_commission')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mt-4 @error('product_info.category_id') has-error @enderror">
                        <label class="form-label">تصنيف<span class="text-danger">*</span></label>
                        <select class="form-control product_info @error('product_info.category_id') is-invalid @enderror" aria-label="Default  select example" name="product_info[category_id]" id="product_info.category_id">
                            <option value="">اختار تصنيف </option>
                            @foreach ($data['categories'] as $cat)
                            <option @if ($cat->id == old('product_info.category_id')) selected @endif value="{{ $cat->id }}">{{ $cat->parents_names }}</option>
                            @endforeach
                        </select>
                        @error('product_info.category_id')
                        <div class="invalid-feedback">
                            {{ __($message) }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 mt-5">
                    <div class="form-check form-switch" style="width: auto;">
                        <input class="form-check-input" type="checkbox" name="product_info[show_quantity]">
                        <label class="form-check-label">عرض فقط متوفر أو غير متوفر</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-check form-switch" style="width: auto;">
                        <input class="form-check-input confirm_order" type="checkbox" name="product_info[confirm_order]">
                        <label class="form-check-label">السماح باكمال الطلب لو المخزون غير كافى</label>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-md-12">
                        <label class="form-label">وصف الباكيدج</label>
                        <textarea id="summernote" type="text" class="form-control product_info " name="product_info[description]">{!! old('product_info.description') !!}</textarea>
                        <div class="invalid-feedback">

                        </div>
                    </div>
                </div>

            <div class="row mb-5">
                <h3 class="form-label">صور الباكيدج <i class="bi bi-images"></i></h3>
                <div class="col-12">
                    <button type="button" class="btn btn-primary my-3 rounded" style="cursor: pointer;" id="addImage">
                        إضف صورة
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                <div class="input-images" style="cursor:pointer;"></div>
            </div>

<div class="row mb-5">
    <h3 class="mb-4">تصنيفات الباكيدج <i class="bi bi-list-ul"></i></h3>
    <div class="col-12">
        <div class="options">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-primary mt-3" id="add_option_btn">إضافة تصنيف</button>
        </div>
    </div>

</div>

<div class="row mb-3">
    <table class="table table-hover fs-4" id="variants_table" style="display: none">
        <thead>
            <tr>
                <th scope="col" style="width: 320px">المنتج</th>
                <th scope="col" style="width: 320px">المتغير</th>
                <th scope="col">السعر</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<button type="submit" class="btn btn-primary btn-lg add_product_btn"> إضافة باكدج <i class="bi bi-plus-square"></i></button>
</div>
</form>
<meta name="_token" content="{{ csrf_token() }}">
@endsection
@section('script')
<script type="text/javascript" src="{{url('/static/js/image-uploader.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('.confirm_order').prop('checked', true);
    });
    $('#addImage').on('click', function() {
        $('.image-uploader input').click();
    })
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
        });
        $('select.product_info').select2({
            padding: 'resolve',
            width: 'resolve',
        });
        $('.input-images').imageUploader();
    })
    form_options_array = [];
    form_options_values = new Object();
    options = {};
    var i = 0;

    var products = @json($data['products']);
    var form_options_data = [];

    $("#add_option_btn").click(function(e) {
        e.preventDefault();
        $('.variants_table').show();
        add_option();
    });
    function add_option() {
        var productOptions = '<option value="">اختر منتج</option>';

        products.forEach(element => {
            if (element.is_bundle == 0)
                productOptions += `<option Isbundle=${element.is_bundle} value="${element.id}">${element.name}</option>`;
        });

        var newRow = `<tr>
                        <td>
                            <select class="form-control product-select name="package[][product_id]">
                                ${productOptions}
                            </select>
                        </td>
                        <td>
                            <select class="form-control variant-select" name="package[${i}][variant_id]">
                                <option value="">اختار المتغير</option>
                            </select>
                        </td>
                        <td><input type="number" name="package[${i}][price]" id="price" class="form-control"></td>
                      </tr>`;
        $("#variants_table tbody").append(newRow);
        $("#variants_table").fadeIn();
        $(".product-select").select2();
        $(".variant-select").select2();
        $(".product-select").last().change(function() {
            var productSelect = $(this);
            var variantSelect = productSelect.closest('tr').find('.variant-select');
            var product_id = productSelect.val();

            variantSelect.html("");
            $.ajax({
                url: `/api/product/${product_id}/variants`,
                method: 'GET',
                dataType: 'text'
            }).then(response => {
                var data = JSON.parse(response);
                variantSelect.append(`<option value="">اختار المتغير</option>`);
                data.forEach(element => {
                    variantSelect.append(`<option data-hide="${element.hide}" ${data.length == 1 ? 'selected' : ''} data-confirm="${element.product.confirm_order}" data-show="${element.product.show_quantity}" value="${element.id}">${element.name}</option>`);
                });
                variantSelect.prop('disabled', false);
                $("#variants").fadeIn();
            });
        });
        form_options_data.push(newRow);
        i++;
    }


    $(document).on("click", "#edit_options_btn", function(e) {
        e.preventDefault();
        $(".option_value_div").fadeIn();
        $(".remove_option").fadeIn();
        $(".remove_option_value i").fadeIn();
        $(".remove_option_value").addClass('hover-danger');
        $(".option_name").prop('readonly', false);
        $(".remove_option_value").prop('disabled', false);
        $("#add_option_btn").fadeIn();
        $(".values_edit").fadeIn();
        $(".values_display").fadeOut();
        $("#save_options_btn").fadeIn();
        $(this).fadeOut();
        console.log(options);
    })

    function options_data_valid() {
        var valid = true;
        form_options_array.forEach(option_id => {
            var option_name = $('#' + option_id + ' .option_name').val();
            var option_values = form_options_values[option_id];

            if (!option_name) {
                valid = false;
                $("#" + option_id + " .invalid-feedback").fadeIn();
                $("#" + option_id + " .option_name").addClass("is-invalid");
            } else {
                $("#" + option_id + " .invalid-feedback").fadeOut();
                $("#" + option_id + " .option_name").removeClass("is-invalid");
            }


            if (option_values === undefined || option_values.length == 0) {
                valid = false;
                $("#" + option_id + " #invalid-" + option_id).fadeIn();
                $("#" + option_id + " .option_values").addClass("is-invalid");
            } else {
                $("#" + option_id + " #invalid-" + option_id).fadeOut();
                $("#" + option_id + " .option_values").removeClass("is-invalid");
            }

        });
        return valid;
    }

    function generate_variants() {
        var variants = [];

        var attributes = {};

        Object.entries(options).forEach(element => {
            attributes[element[1].option_name] = element[1].option_values;
        });

        for (const [attr, values] of Object.entries(attributes))
            variants.push(values.map(v => ({
                [attr]: v
            })));

        variants = variants.reduce((a, b) => a.flatMap(d => b.map(e => ({
            ...d,
            ...e
        }))));

        variants.forEach(variant => {
            variant.name = Object.keys(variant).map(key => variant[key]).join('-');
            // console.log(variant);
        });

        add_variants_to_table(variants);

    }

    function add_variants_to_table(variants) {
        $("#variants_table tbody").html("");
        variants.forEach((element, index) => {
            var template = `
            `;
            template += `<td>` +
                `<input class="form-control form-control-sm" id="formFileSm" name="product_variants[` + index + `][photo]" type="file"/></td>` +
                `</tr>`;
            $("#variants_table tbody").append(template);
        });
        $("#variants_table").fadeIn();
    }
</script>
@endsection
