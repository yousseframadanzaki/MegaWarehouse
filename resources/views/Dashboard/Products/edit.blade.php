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
    </style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_products') }}">المنتجات</a></li>
                <li><a href="{{ route('show_product', $data['product']->id) }}">{{ $data['product']->name }}</a></li>
                <li>تعديل منتج</li>
            </ul>
        </div>
        <form class="row  needs-validation " enctype="multipart/form-data" action="{{route('update_product',$data['product']->id)}}" method="POST">
            @csrf
            <div class="card p-3 shadow-sm">
                <h3 class="text-center">تعديل منتج </h3>
                <div class="row mb-3">
                    <h3>بيانات المنتج <i class="bi bi-box-fill"></i></h3>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control product_info @error('name') is-invalid @enderror"
                                name="product_info[name]" value="{{ $data['product']->name }}">

                            <div class="invalid-feedback name">

                            </div>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ماركة المنتج<span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default  select example" name="product_info[brand_id]"
                                style="padding: 0.375rem 0.75rem;">
                                <option value="">اختار الماركة</option>
                                @foreach ($data['brands'] as $id => $name)
                                    <option @if ($data['product']->brand_id == $id) selected @endif value="{{ $id }}">
                                        {{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback brand_id">

                            </div>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('price') is-invalid @enderror"
                                name="product_info[price]" value="{{ $data['product']->price }}">

                            <div class="invalid-feedback price">

                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">السعر قبل الخصم</label>
                            <input type="number"
                                class="form-control product_info @error('before_sale_price') is-invalid @enderror"
                                name="product_info[before_sale_price]" value="{{ $data['product']->before_sale_price }}">
                            <div class="invalid-feedback before_sale_price">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">تكلفة المنتج <span class="text-danger">*</span></label>
                            <input type="number" class="form-control product_info @error('cost') is-invalid @enderror"
                                name="product_info[cost]" value="{{ $data['product']->cost }}">
                            <div class="invalid-feedback cost">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default select example" name="product_info[supplier_id]">
                                <option value="">اختار المورد</option>
                                @foreach ($data['suppliers'] as $id => $name)
                                    <option @if ($data['product']->supplier_id == $id) selected @endif value="{{ $id }}">
                                        {{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback supplier_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">تصنيف<span class="text-danger">*</span></label>
                            <select class="form-select product_info" aria-label="Default  select example" name="product_info[category_id]"
                                id="category_id">
                                <option value="">اختار تصنيف </option>
                                @foreach ($data['categories'] as $cat)
                                    <option @if ($data['product']->category_id == $cat->id) selected @endif value="{{ $cat->id }}">
                                        {{ $cat->parents_names }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback category_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check form-switch" style="width: auto;">
                            <input class="form-check-input" type="checkbox" name="product_info[show_quantity]" {{ $data['product']->show_quantity == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">عرض فقط متوفر أو غير متوفر</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-check form-switch" style="width: auto;">
                            <input class="form-check-input" type="checkbox" name="product_info[confirm_order]" {{ $data['product']->confirm_order == 1 ? 'checked' : '' }}>
                            <label class="form-check-label">السماح باكمال الطلب لو المخزون غير كافى</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">وصف المنتج</label>
                            <textarea id="summernote" type="text" class="form-control product_info @error('description') is-invalid @enderror"
                                name="product_info[description]">{{ $data['product']->description }}</textarea>
                            <div class="invalid-feedback description">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <h3 class="form-label">صور المنتج <i class="bi bi-images"></i></h3>
                    <div class="input-images"></div>
                </div>

                <button id="edit_product_btn" type="submit" class="btn btn-primary btn-lg">تعديل المنتج <i
                        class="bi bi-plus-square"></i></button>
            </div>
        </form>
        <meta name="_token" content="{{ csrf_token() }}">
    @endsection
    @section('script')
        <script type="text/javascript" src="{{ url('/static/js/image-uploader.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                var images = {!! json_encode($data['product']->images) !!}
                var main_image = {!! json_encode($data['product']->main_image) !!}
                if (main_image) {
                    images.push(main_image);
                }

                var preloaded = images.map(({
                    id,
                    path
                }) => {
                    return {
                        id: id,
                        src: '/storage/' + path
                    }
                });
                console.log(preloaded);
                $('#summernote').summernote({
                    height: 200,
                });
                $('select.product_info').select2({
                    padding: 'resolve',
                });
                $('.input-images').imageUploader({
                    imagesInputName: 'product_images',
                    preloadedInputName:'preloaded_images',
                    preloaded: preloaded
                });
            })



            // $("#edit_product_btn").click(function(e) {
            //     e.preventDefault();

            // })

            // form_options_array = [];
            // form_options_values = new Object();
            // options = {};

            // $("#add_option_btn").click(function(e) {
            //     e.preventDefault();
            //     var options_count = form_options_array.length;
            //     add_option();
            //     if (options_count >= 0) {
            //         $('#save_options_btn').fadeIn();
            //     }
            //     if (options_count + 1 == 3) {
            //         $(this).fadeOut();
            //     }
            // })

            // function add_option() {
            //     var option_id = uid();
            //     form_options_array.push(option_id);
            //     var option_template = `
    //     <div class="option row mb-3 border shadow-sm p-3" id="` + option_id + `">
    //         <div class="col-md-5">
    //             <label class="form-label">اسم الاختيار <span class="text-danger">*</span></label>
    //             <input type="text" class="form-control option_name"  list="default_options">
    //             <div class="invalid-feedback">
    //                 برجاء أضافة اسم الاختيار
    //             </div>
    //         </div>
    //         <div class="col-md-5 values_display" style="display:none;">
    //             <label class="form-label">قيم الاختيار:-</label>
    //             <div class="option_values_div">

    //             </div>
    //         </div>
    //         <div class="col-md-5 option_value_div">
    //             <label class="form-label">قيم الاختيار <span class="text-danger">*</span></label>
    //             <input type="text" class="form-control option_values" data-option-id="` + option_id + `" placeholder="برجاء ادخال القيمة والضغط على زر enter">
    //             <div id="invalid-` + option_id + `" class="invalid-feedback">
    //                 برجاء أضافة قيم الاختيار
    //             </div>
    //         </div>
    //         <div class="col-md-2 d-md-flex align-items-end">
    //             <a class="remove_option btn btn-danger" data-remove-id="` + option_id + `"><i class="bi bi-trash"></i></a>
    //         </div>
    //         <div class="row mt-3 values_edit">
    //             <label class="form-label">قيم الاختيار:-</label>
    //             <div class="option_values_div">

    //             </div>
    //         </div>
    //     </div>
    //     `;
            //     $('.options').append(option_template);
            // }

            // $(document).on("click", ".remove_option", function(e) {
            //     e.preventDefault();
            //     var remove_id = $(this).attr("data-remove-id");
            //     $("#" + remove_id).fadeOut();
            //     $("#" + remove_id).remove();
            //     delete form_options_values[remove_id];
            //     delete options[remove_id];
            //     update_form_options();
            //     const index = form_options_array.indexOf(remove_id);

            //     if (index > -1) {
            //         form_options_array.splice(index, 1);
            //     }
            //     if (form_options_array.length < 3) {
            //         $("#add_option_btn").fadeIn();
            //     }
            //     var options_count = form_options_array.length;
            //     if (options_count === 0) {
            //         $('#save_options_btn').fadeOut();
            //         $('#variants_table tbody').html("");
            //         $('#variants_table').fadeOut();
            //     }
            // });

            // const uid = function() {
            //     return Date.now().toString(36) + Math.random().toString(36).substr(2);
            // }

            // $(document).on("keypress", ".option_name", function(e) {
            //     if (e.keyCode == 13) {
            //         e.preventDefault();
            //     }
            // })

            // $(document).on("keypress", ".option_values", function(e) {
            //     if (e.keyCode == 13) {
            //         e.preventDefault();
            //         var value = $(this).val();
            //         if (!value) {
            //             return false;
            //         }
            //         var option_id = $(this).attr('data-option-id');
            //         if (form_options_values[option_id]) {
            //             form_options_values[option_id].push(value);
            //         } else {
            //             form_options_values[option_id] = [value];
            //         }
            //         $(this).val("");
            //         update_form_options();
            //     }
            // });

            // function update_form_options() {
            //     $('.option_values_div').html('')
            //     Object.keys(form_options_values).forEach(key => {
            //         form_options_values[key].forEach(value => {
            //             var template = `
    //         <div
    //             class="remove_option_value hover-danger btn btn-success option_value_` + key + `"
    //             style="margin-left:10px"
    //             data-value="${value}"
    //             data-option-id="${key}"
    //         >
    //             ${value}
    //             <i class="bi bi-trash"></i>
    //         </div>`
            //             $('#' + key + ' .option_values_div').append(template);
            //         });
            //     });
            // }

            // $(document).on("click", ".remove_option_value", function(e) {
            //     var option_id = $(this).attr("data-option-id");
            //     var value = $(this).attr("data-value");

            //     const index = form_options_values[option_id].indexOf(value);
            //     if (index > -1) {
            //         form_options_values[option_id].splice(index, 1);
            //     }
            //     update_form_options();
            // })

            // $(document).on("click", "#save_options_btn", function(e) {
            //     e.preventDefault();


            //     if (!options_data_valid()) {
            //         return;
            //     }

            //     form_options_array.forEach(option_id => {
            //         var option_name = $('#' + option_id + ' .option_name').val();
            //         options[option_id] = {
            //             option_name: option_name,
            //             option_values: form_options_values[option_id]
            //         };
            //     });

            //     generate_variants();

            //     $(".option_value_div").fadeOut();
            //     $(".remove_option").fadeOut();
            //     $(".remove_option_value i").fadeOut();
            //     $(".remove_option_value").removeClass('hover-danger');
            //     $(".option_name").prop('readonly', true);
            //     $(".remove_option_value").prop('disabled', true);
            //     $("#add_option_btn").fadeOut();
            //     $(".values_edit").fadeOut();
            //     $(".values_display").fadeIn();

            //     $("#edit_options_btn").fadeIn();
            //     $(this).fadeOut();

            // })

            // $(document).on("click", "#edit_options_btn", function(e) {
            //     e.preventDefault();
            //     $(".option_value_div").fadeIn();
            //     $(".remove_option").fadeIn();
            //     $(".remove_option_value i").fadeIn();
            //     $(".remove_option_value").addClass('hover-danger');
            //     $(".option_name").prop('readonly', false);
            //     $(".remove_option_value").prop('disabled', false);
            //     $("#add_option_btn").fadeIn();
            //     $(".values_edit").fadeIn();
            //     $(".values_display").fadeOut();
            //     $("#save_options_btn").fadeIn();
            //     $(this).fadeOut();
            //     console.log(options);
            // })

            // function options_data_valid() {
            //     var valid = true;
            //     form_options_array.forEach(option_id => {
            //         var option_name = $('#' + option_id + ' .option_name').val();
            //         var option_values = form_options_values[option_id];

            //         if (!option_name) {
            //             valid = false;
            //             $("#" + option_id + " .invalid-feedback").fadeIn();
            //             $("#" + option_id + " .option_name").addClass("is-invalid");
            //         } else {
            //             $("#" + option_id + " .invalid-feedback").fadeOut();
            //             $("#" + option_id + " .option_name").removeClass("is-invalid");
            //         }


            //         if (option_values === undefined || option_values.length == 0) {
            //             valid = false;
            //             $("#" + option_id + " #invalid-" + option_id).fadeIn();
            //             $("#" + option_id + " .option_values").addClass("is-invalid");
            //         } else {
            //             $("#" + option_id + " #invalid-" + option_id).fadeOut();
            //             $("#" + option_id + " .option_values").removeClass("is-invalid");
            //         }

            //     });
            //     return valid;
            // }

            // function generate_variants() {
            //     var variants = [];

            //     var attributes = {};

            //     Object.entries(options).forEach(element => {
            //         attributes[element[1].option_name] = element[1].option_values;
            //     });

            //     for (const [attr, values] of Object.entries(attributes))
            //         variants.push(values.map(v => ({
            //             [attr]: v
            //         })));

            //     variants = variants.reduce((a, b) => a.flatMap(d => b.map(e => ({
            //         ...d,
            //         ...e
            //     }))));

            //     variants.forEach(variant => {
            //         variant.name = Object.keys(variant).map(key => variant[key]).join(' / ');
            //         // console.log(variant);
            //     });

            //     add_variants_to_table(variants);

            // }

            // function add_variants_to_table(variants) {
            //     $("#variants_table tbody").html("");
            //     variants.forEach((element, index) => {
            //         var template = `
    //         <tr>
    //         <td>` + element.name + `</td>
    //         <td><input class=" product_variant form-control" name="product_variants[` + index + `][price]" type="number"/></td>
    //         <td><input class="sku product_variant form-control" name="product_variants[` + index + `][sku]" type="text"/></td>
    //         <input type="hidden" class="product_variant" name="product_variants[` + index +
            //             `][name]" value="` + element.name + `"/>`
            //         Object.entries(element).forEach(option_value => {
            //             if (option_value[0] != 'name') {
            //                 template += `<input type="hidden" class="product_variant" name="product_variants[` +
            //                     index + `][options][` + option_value[0] + `]" value="` + option_value[1] + `"/>`
            //             }
            //         });
            //         template += `</tr>`;
            //         $("#variants_table tbody").append(template);
            //     });
            //     $("#variants_table").fadeIn();
            // }

            // Dropzone.options.productForm = {

            //     autoProcessQueue: false,
            //     uploadMultiple: true,
            //     parallelUploads: 5,
            //     maxFiles: 5,

            //     addRemoveLinks: true,
            //     dictRemoveFile: "×",
            //     paramName: "product_images",
            //     thumbnailMethod:"contain",
            //     error: function(file, msg) {
            //         console.log(msg);
            //     },
            //     init: function() {
            //         var myDropzone = this;

            //         this.on("thumbnail", function(file) {
            //             $(file.previewElement).append("<input type='checkbox'  class='form-check-input checkbox' id='"+file.upload.uuid+"' />");

            //             $("#"+file.upload.uuid).click(function () {
            //                 if (file.is_main) {
            //                     file.is_main = false;
            //                     $(this).prop("checked",false);
            //                 } else {
            //                     $("#product-form input[type=checkbox]").prop("checked",false);
            //                     myDropzone.files.forEach(element => {
            //                         element.is_main = false;
            //                     });
            //                     file.is_main = true;
            //                     $(this).prop("checked",true);
            //                 }
            //                 console.log(file);
            //             })


            //             file.previewElement.addEventListener("click", function() {

            //             });
            //         });

            //         $("#add_product_btn").click(function(e) {
            //             e.preventDefault();
            //             e.stopPropagation();
            //             append_product_data();
            //             if (myDropzone.getQueuedFiles().length === 0) {
            //                 var blob = new Blob();
            //                 blob.upload = {
            //                     'chunked': myDropzone.defaultOptions.chunking
            //                 };
            //                 myDropzone.uploadFile(blob);
            //             } else {
            //                 myDropzone.processQueue();
            //             }

            //         });

            //         this.on("sendingmultiple", function(data, xhr, formData) {
            //             myDropzone.files.forEach(file => {
            //                 if (file.is_main) {
            //                     formData.append("main_image", file);
            //                 } else {
            //                     formData.append("product_images[]", file);
            //                 }
            //             });

            //         });

            //         this.on("successmultiple", function(files, response) {
            //             window.location.href = window.location.href;
            //             // console.log(response);
            //         });

            //         this.on("errormultiple", function(files, response) {
            //             Object.entries(response.errors).forEach(error => {
            //                 error_field_type = error[0].split('.')[0];
            //                 error_field = error[0].split('.')[1];
            //                 console.log(".invalid-feedback." + error_field);
            //                 $("input[name=" + error_field + "]").addClass("is-invalid");
            //                 $("select[name=" + error_field + "]").addClass("is-invalid");
            //                 $(".invalid-feedback." + error_field).text(error[1]);
            //             });

            //             $("#product-form input[type=hidden]").remove();
            //             token = $('meta[name="_token"]').attr('content')
            //             $("#product-form").append("<input type='hidden' name='_token' value="+token+" />");
            //             $(window).scrollTop(0);
            //         });
            //     }
            // }

            // function append_product_data() {
            //     $(".product_info").each(function() {

            //         if($(this).attr('name') === "description"){
            //             var template = `<input type="hidden" name="product_info[` + $(this).attr('name') + `]" value="` + $(
            //             this).summernote("code") + `" />`
            //             $("#product-form").append(template);
            //             return;
            //         }

            //         var template = `<input type="hidden" name="product_info[` + $(this).attr('name') + `]" value="` + $(
            //             this).val() + `" />`
            //         $("#product-form").append(template);
            //     });
            //     Object.entries(options).forEach(element => {
            //         var option = element[1];
            //         option.option_values.forEach(value => {
            //             var option_template = `<input type="hidden" name="product_attributes[` + option
            //                 .option_name + `][]" value="` + value + `"/>`;
            //             $("#product-form").append(option_template);
            //         });
            //     });

            //     $(".product_variant").each(function() {
            //         var template = `<input type="hidden" name="` + $(this).attr('name') + `" value="` + $(this).val() +
            //             `" />`
            //         $("#product-form").append(template);
            //     });

            // }

            // $(".remove_image").click(function () {
            //     var id = $(this).attr("data-id");
            //     $.ajax({
            //         url:"/api/media/"+id,
            //         method:"DELETE",
            //         data:'json'
            //     }).then(response =>{
            //         console.log(response);
            //         if(response === 1){
            //             $("#"+id).fadeOut();
            //         }
            //     })
            // })
        </script>
    @endsection
