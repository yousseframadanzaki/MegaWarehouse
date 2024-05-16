
@extends('layouts.app')
@section('content')
    <style>
        .hover-danger:hover {
            color: white;
            background: var(--bs-danger);
            border-color: transparent;
        }
        .checkbox { position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            width: 20px;
            height: 20px;
         }

    </style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_products') }}">المنتجات</a></li>
                <li>اضافة منتج جديد</li>
            </ul>
        </div>
        <form class="row  " id="product-form" enctype="multipart/form-data" action="{{route('store_product')}}" method="POST">
            @csrf
            <div class="card p-3 shadow-sm">
                <h3 class="text-center">أضافة منتج جديد</h3>
                <div class="row mb-3">
                    <h3>بيانات المنتج <i class="bi bi-box-fill"></i></h3>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control product_info @error('product_info.name') is-invalid @enderror"
                                name="product_info[name]" value="{{ old('product_info.name') }}">
                            @error('product_info.name')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 @error('product_info.brand_id') has-error @enderror">
                            <label class="form-label">ماركة المنتج<span class="text-danger">*</span></label>
                            <select class="form-select product_info @error('product_info.brand_id') is-invalid @enderror" aria-label="Default  select example" name="product_info[brand_id]" style="padding: 0.375rem 0.75rem;">
                                <option value="">اختار الماركة</option>
                                @foreach ($data['brands'] as $id => $name)
                                    <option @if ($id == old('product_info.brand_id')) selected @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>

                            @error('product_info.brand_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('product_info.price') is-invalid @enderror"
                                name="product_info[price]" value="{{ old('product_info.price') }}">

                                @error('product_info.price')
                                    <div class="invalid-feedback">
                                        {{ __($message) }}
                                    </div>
                                @enderror

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">السعر قبل الخصم</label>
                            <input type="number"
                                class="form-control product_info @error('product_info.before_sale_price') is-invalid @enderror"
                                name="product_info[before_sale_price]" value="{{ old('product_info.before_sale_price') }}">
                                @error('product_info.before_sale_price')
                                    <div class="invalid-feedback">
                                        {{ __($message) }}
                                    </div>
                                @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تكلفة المنتج <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('product_info.cost') is-invalid @enderror"
                                name="product_info[cost]" value="{{ old('product_info.cost') }}">

                                @error('product_info.cost')
                                    <div class="invalid-feedback">
                                        {{ __($message) }}
                                    </div>
                                @enderror

                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-6 @error('product_info.category_id') has-error @enderror">
                            <label class="form-label">تصنيف<span class="text-danger">*</span></label>
                            <select class="form-select product_info @error('product_info.category_id') is-invalid @enderror" aria-label="Default  select example" name="product_info[category_id]"
                                id="product_info.category_id">
                                <option value="">اختار تصنيف </option>
                                @foreach ($data['categories'] as $cat)
                                    <option @if ($cat->id == old('product_info.category_id')) selected @endif  value="{{ $cat->id }}">{{ $cat->parents_names }}</option>
                                @endforeach
                            </select>
                            @error('product_info.category_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        {{-- @dd(old('product_info.supplier_id')) --}}
                        <div class="col-md-6 @error('product_info.supplier_id') has-error @enderror">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select class="form-select product_info  @error('product_info.supplier_id') is-invalid @enderror" aria-label="Default select example" name="product_info[supplier_id]">
                                <option value="">اختار المورد</option>
                                @foreach ($data['suppliers'] as $id => $name)
                                    <option @if ($id == old('product_info.supplier_id')) selected="selected"  @endif value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('product_info.supplier_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check form-switch" style="width: auto;">
                            <input class="form-check-input" type="checkbox" name="product_info[show_quantity]">
                            <label class="form-check-label">عرض فقط متوفر أو غير متوفر</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check form-switch" style="width: auto;">
                            <input class="form-check-input" type="checkbox" name="product_info[confirm_order]">
                            <label class="form-check-label">السماح باكمال الطلب لو المخزون غير كافى</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">وصف المنتج</label>
                            <textarea id="summernote" type="text" class="form-control product_info "
                                name="product_info[description]">{!! old('product_info.description') !!}</textarea>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <h3 class="form-label">صور المنتج <i class="bi bi-images"></i></h3>
                    <div class="input-images"></div>
                </div>

                {{-- <div class="row mb-3">
                    <h3 class="form-label">صور المنتج <i class="bi bi-images"></i></h3>
                    <div class="col-md-12">
                        <form class="dropzone" id="product-form" action="{{ route('store_product') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <textarea style="display: none" name="product_info[description]" id="description"></textarea>
                            <div class="dropzone-previews">

                            </div>
                            <div class="dz-message" data-dz-message><span>قم بالضغط لرفع الصور</span></div>
                        </form>
                    </div>
                </div> --}}

                <div class="row mb-3 mt-2">
                    <h3>اختيارات المنتج <i class="bi bi-list-ul"></i></h3>
                    <div class="options">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary mt-3" id="add_option_btn">أضافة اختيار</button>
                            <button class="btn btn-success mt-3" id="save_options_btn" style="display: none">حفظ
                                الاختيارات</button>
                            <button class="btn btn-dark mt-3" id="edit_options_btn" style="display: none">تعديل
                                الاختيارات</button>
                        </div>
                    </div>

                </div>

                <div class="row mb-3">
                    <table class="table table-hover fs-4" id="variants_table" style="display: none;">
                        <thead>
                            <tr>
                                <th scope="col">اسم</th>
                                <th scope="col">سعر</th>
                                <th scope="col">sku</th>
                                <th scope="col">اضافة صورة</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <button class="btn btn-primary btn-lg add_product_btn">أضافة المنتج <i
                        class="bi bi-plus-square"></i></button>
            </div>
            <datalist id="default_options">
                <option value="المقاس">
                <option value="اللون">
                <option value="الخامة">
            </datalist>
        </form>
    <meta name="_token" content="{{ csrf_token() }}">
    @endsection
@section('script')
<script type="text/javascript" src="{{url('/static/js/image-uploader.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
        });
        $('select.product_info').select2({
            padding: 'resolve',
        });
        $('.input-images').imageUploader({
            imagesInputName:'product_images'
        });
    })
    form_options_array = [];
    form_options_values = new Object();
    options = {};

    $("#add_option_btn").click(function(e) {
        e.preventDefault();
        var options_count = form_options_array.length;
        add_option();
        if (options_count >= 0) {
            $('#save_options_btn').fadeIn();
        }
        if (options_count + 1 == 3) {
            $(this).fadeOut();
        }
    })
    function add_option() {
        var option_id = uid();
        form_options_array.push(option_id);
        var option_template = `
        <div class="option row mb-3 border shadow-sm p-3" id="` + option_id + `">
            <div class="col-md-5">
                <label class="form-label">اسم الاختيار <span class="text-danger">*</span></label>
                <input type="text" class="form-control option_name"  list="default_options">
                <div class="invalid-feedback">
                    برجاء أضافة اسم الاختيار
                </div>
            </div>
            <div class="col-md-5 values_display" style="display:none;">
                <label class="form-label">قيم الاختيار:-</label>
                <div class="option_values_div">

                </div>
            </div>
            <div class="col-md-5 option_value_div">
                <label class="form-label">قيم الاختيار <span class="text-danger">*</span></label>
                <input type="text" class="form-control option_values" data-option-id="` + option_id + `" placeholder="برجاء ادخال القيمة والضغط على زر enter">
                <div id="invalid-` + option_id + `" class="invalid-feedback">
                    برجاء أضافة قيم الاختيار
                </div>
            </div>
            <div class="col-md-2 d-md-flex align-items-end">
                <a class="remove_option btn btn-danger" data-remove-id="` + option_id + `"><i class="bi bi-trash"></i></a>
            </div>
            <div class="row mt-3 values_edit">
                <label class="form-label">قيم الاختيار:-</label>
                <div class="option_values_div">

                </div>
            </div>
        </div>
        `;
        $('.options').append(option_template);
    }
    const uid = function() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }
    $(document).on("click", ".remove_option", function(e) {
        e.preventDefault();
        var remove_id = $(this).attr("data-remove-id");
        $("#" + remove_id).fadeOut();
        $("#" + remove_id).remove();
        delete form_options_values[remove_id];
        delete options[remove_id];
        update_form_options();
        const index = form_options_array.indexOf(remove_id);

        if (index > -1) {
            form_options_array.splice(index, 1);
        }
        if (form_options_array.length < 3) {
            $("#add_option_btn").fadeIn();
        }
        var options_count = form_options_array.length;
        if (options_count === 0) {
            $('#save_options_btn').fadeOut();
            $('#variants_table tbody').html("");
            $('#variants_table').fadeOut();
        }
    });
    $(document).on("keypress", ".option_name", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    })

    $(document).on("keypress", ".option_values", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var value = $(this).val();
            if (!value) {
                return false;
            }
            var option_id = $(this).attr('data-option-id');
            if (form_options_values[option_id]) {
                form_options_values[option_id].push(value);
            } else {
                form_options_values[option_id] = [value];
            }
            $(this).val("");
            update_form_options();
        }
    });

    function update_form_options() {
        $('.option_values_div').html('')
        Object.keys(form_options_values).forEach(key => {
            form_options_values[key].forEach(value => {
                var template = `
            <div
                class="remove_option_value hover-danger btn btn-success option_value_` + key + `"
                style="margin-left:10px"
                data-value="${value}"
                data-option-id="${key}"
            >
                ${value}
                <i class="bi bi-trash"></i>
            </div>`
                $('#' + key + ' .option_values_div').append(template);
            });
        });
    }

    $(document).on("click", ".remove_option_value", function(e) {
        var option_id = $(this).attr("data-option-id");
        var value = $(this).attr("data-value");

        const index = form_options_values[option_id].indexOf(value);
        if (index > -1) {
            form_options_values[option_id].splice(index, 1);
        }
        update_form_options();
    })

    $(document).on("click", "#save_options_btn", function(e) {
        e.preventDefault();


        if (!options_data_valid()) {
            return;
        }

        form_options_array.forEach(option_id => {
            var option_name = $('#' + option_id + ' .option_name').val();
            options[option_id] = {
                option_name: option_name,
                option_values: form_options_values[option_id]
            };
        });

        generate_variants();

        $(".option_value_div").fadeOut();
        $(".remove_option").fadeOut();
        $(".remove_option_value i").fadeOut();
        $(".remove_option_value").removeClass('hover-danger');
        $(".option_name").prop('readonly', true);
        $(".remove_option_value").prop('disabled', true);
        $("#add_option_btn").fadeOut();
        $(".values_edit").fadeOut();
        $(".values_display").fadeIn();

        $("#edit_options_btn").fadeIn();
        $(this).fadeOut();

    })

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
            <tr>
            <td>` + element.name + `</td>
            <td><input class=" product_variant form-control" name="product_variants[` + index + `][price]" type="number"/></td>
            <td><input class="sku product_variant form-control" name="product_variants[` + index + `][sku]" type="text"/></td>
            <input type="hidden" class="product_variant" name="product_variants[` + index +
                `][name]" value="` + element.name + `"/>`
            Object.entries(element).forEach(option_value => {
                if (option_value[0] != 'name') {
                    template += `<input type="hidden" class="product_variant" name="product_variants[` +
                        index + `][options][` + option_value[0] + `]" value="` + option_value[1] + `"/>`
                }
            });
            //template += `</tr>`;
            template += `<td>` +
            `<input class="form-control form-control-sm" id="formFileSm" name="product_variants[` + index + `][photo]" type="file"/></td>` +
            `</tr>`;
            $("#variants_table tbody").append(template);
        });
        $("#variants_table").fadeIn();
    }

    $('.add_product_btn').on('click',function (e) {
        e.preventDefault();
        Object.entries(options).forEach(element => {
            var option = element[1];
            option.option_values.forEach(value => {
                var option_template = `<input type="hidden" name="product_attributes[` + option
                    .option_name + `][]" value="` + value + `"/>`;
                $("#product-form").append(option_template);
            });
        });

        $(".product_variant").each(function() {
            var template = `<input type="hidden" name="` + $(this).attr('name') + `" value="` + $(this).val() +
                `" />`
            $("#product-form").append(template);
        });
        $("#product-form").submit();
    })
</script>
@endsection
