
@extends('layouts.app')
@section('content')
    <style>
        .hover-danger:hover {
            color: white;
            background: var(--bs-danger);
            border-color: transparent;
        }
    </style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_roles') }}">المنتجات</a></li>
                <li>اضافة منتج جديد</li>
            </ul>
        </div>
        <div class="row  needs-validation " novalidate>
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة منتج جديد</h1>
                <div class="row mb-3">
                    <h3>بيانات المنتج <i class="bi bi-box-fill"></i></h3>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control product_info @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}">

                            <div class="invalid-feedback name">

                            </div>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ماركة المنتج<span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default  select example" name="brand_id">
                                <option value="">اختار الماركة</option>
                                @foreach ($data['brands'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback brand_id">

                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('price') is-invalid @enderror"
                                name="price" value="{{ old('price') }}">

                            <div class="invalid-feedback price">

                            </div>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label">السعر بعد الخصم</label>
                            <input type="number"
                                class="form-control product_info @error('sale_price') is-invalid @enderror"
                                name="sale_price" value="{{ old('sale_price') }}">
                            <div class="invalid-feedback sale_price">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">تكلفة المنتج <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('cost') is-invalid @enderror"
                                name="cost" value="{{ old('cost') }}">

                            <div class="invalid-feedback cost">

                            </div>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default select example" name="supplier_id">
                                <option value="">اختار المورد</option>
                                @foreach ($data['suppliers'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">تصنيف<span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default  select example" name="category_id"
                                id="category_id">
                                <option value="">اختار تصنيف </option>
                                @foreach ($data['categories']->get() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->parents_names }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback category_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">وصف المنتج</label>
                            <textarea id="summernote" type="text" class="form-control product_info @error('description') is-invalid @enderror"
                                name="description"></textarea>
                            <div class="invalid-feedback description">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <h3 class="form-label">صور المنتج <i class="bi bi-images"></i></h3>
                    <div class="col-md-12">
                        <form class="dropzone" id="product-form" action="{{ route('store_product') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="dropzone-previews">

                            </div>
                            <div class="dz-message" data-dz-message><span>قم بالضغط لرفع الصور</span></div>
                        </form>
                    </div>
                </div>

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
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <button id="add_product_btn" type="submit" class="btn btn-primary btn-lg">أضافة المنتج <i
                        class="bi bi-plus-square"></i></button>
            </div>
            <datalist id="default_options">
                <option value="المقاس">
                <option value="اللون">
                <option value="الخامة">
            </datalist>
    </div>
    <meta name="_token" content="{{ csrf_token() }}">
    @endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
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

        const uid = function() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        }

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
                variant.name = Object.keys(variant).map(key => variant[key]).join(' / ');
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
                template += `</tr>`;
                $("#variants_table tbody").append(template);
            });
            $("#variants_table").fadeIn();
        }

        Dropzone.options.productForm = {

            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,

            addRemoveLinks: true,
            dictRemoveFile: "×",
            paramName: "product_images",
            error: function(file, msg) {
                console.log(msg);
            },
            init: function() {
                var myDropzone = this;

                this.on("thumbnail", function(file) {

                    file.previewElement.addEventListener("click", function() {
                        if (file.is_main) {
                            $(this).removeClass("tumbnail-selected");
                            file.is_main = false;
                        } else {
                            $(".dz-preview").removeClass("tumbnail-selected");
                            myDropzone.files.forEach(element => {
                                element.is_main = false;
                            });
                            $(this).addClass("tumbnail-selected");
                            file.is_main = true;
                        }
                    });
                });

                $("#add_product_btn").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    append_product_data();
                    if (myDropzone.getQueuedFiles().length === 0) {
                        var blob = new Blob();
                        blob.upload = {
                            'chunked': myDropzone.defaultOptions.chunking
                        };
                        myDropzone.uploadFile(blob);
                    } else {
                        myDropzone.processQueue();
                    }

                });

                this.on("sendingmultiple", function(data, xhr, formData) {
                    myDropzone.files.forEach(file => {
                        if (file.is_main) {
                            formData.append("main_image", file);
                        } else {
                            formData.append("product_images[]", file);
                        }
                    });

                });

                this.on("successmultiple", function(files, response) {
                    window.location.href = window.location.href;
                    // console.log(response);
                });

                this.on("errormultiple", function(files, response) {
                    Object.entries(response.errors).forEach(error => {
                        error_field_type = error[0].split('.')[0];
                        error_field = error[0].split('.')[1];
                        console.log(".invalid-feedback." + error_field);
                        $("input[name=" + error_field + "]").addClass("is-invalid");
                        $("select[name=" + error_field + "]").addClass("is-invalid");
                        $(".invalid-feedback." + error_field).text(error[1]);
                    });

                    $("#product-form input[type=hidden]").remove();
                    token = $('meta[name="_token"]').attr('content')
                    $("#product-form").append("<input type='hidden' name='_token' value="+token+" />");
                    $(window).scrollTop(0);
                });
            }
        }

        function append_product_data() {
            $(".product_info").each(function() {

                if($(this).attr('name') === "description"){
                    var template = `<input type="hidden" name="product_info[` + $(this).attr('name') + `]" value="` + $(
                    this).summernote("code") + `" />`
                    $("#product-form").append(template);
                    return;
                }

                var template = `<input type="hidden" name="product_info[` + $(this).attr('name') + `]" value="` + $(
                    this).val() + `" />`
                $("#product-form").append(template);
            });
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

        }

    </script>
@endsection
