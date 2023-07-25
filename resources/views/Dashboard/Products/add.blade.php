@extends('layouts.app')
@section('content')
<style>

    .hover-danger:hover{
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
        <form class="row  needs-validation" novalidate action="{{ route('store_product') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة منتج جديدة</h1>
                <div class="row mb-3">
                    <h3>بيانات المنتج <i class="bi bi-box-fill"></i></h3>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ماركة المنتج<span class="text-danger">*</span></label>
                            <select class="form-select" aria-label="Default select example" name="brand_id">
                                <option>اختار الماركة</option>
                                @foreach ($data['brands'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">وصف المنتج</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                                value="{{ old('description') }}"></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">السعر بعد الخصم</label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price"
                                value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">تكلفة المنتج <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" name="cost"
                                value="{{ old('cost') }}">
                            @error('cost')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select class="form-select" aria-label="Default select example" name="supplier_id">
                                <option>اختار المورد</option>
                                @foreach ($data['suppliers'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">تصنيف الرئيسى<span class="text-danger">*</span></label>
                            <select class="form-select" aria-label="Default select example" name="main_category_id" id="main_category_id">
                                <option>اختار تصنيف الرئيسى</option>
                                @foreach ($data['categories'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('main_category_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تصنيف الفرعى<span class="text-danger">*</span></label>
                            <select class="form-select" aria-label="Default select example" name="sub_category_id" id="sub_category_id">
                                
                            </select>
                            @error('sub_category_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 >اختيارات المنتج <i class="bi bi-list-ul"></i></h3>
                    <div class="options mt-3">
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-primary mt-3" id="add_option_btn">أضافة اختيار</button>
                            <button class="btn btn-success mt-3" id="save_options_btn" style="display: none">حفظ الاختيارات</button>
                        </div>
                        
                    </div>
                    
                </div>
        </form>
        <datalist id="default_options">
            <option value="المقاس">
            <option value="اللون">
            <option value="الخامة">
        </datalist>
    </div>
    <script>

        form_options_array = [];
        form_options_values = new Object();

        $("#add_option_btn").click(function (e) {
            e.preventDefault();
            var options_count = form_options_array.length;
            add_option();
            if(options_count >= 0){
                $('#save_options_btn').fadeIn();
            }
            if(options_count+1 == 3){
                $(this).fadeOut();
            }
        })

        function add_option() {
            var option_id = uid();
            form_options_array.push(option_id);
            var option_template = `
            <div class="option row mb-3 border shadow-sm p-3" id="`+option_id+`">
                <div class="col-md-5">
                    <label class="form-label">اسم الاختيار <span class="text-danger">*</span></label>
                    <input type="text" class="form-control option_name"  list="default_options">
                </div>
                <div class="col-md-5">
                    <label class="form-label">قيم الاختيار <span class="text-danger">*</span></label>
                    <input type="text" class="form-control option_values" data-option-id="`+option_id+`">
                </div>
                <div class="col-md-2 d-md-flex align-items-end">
                    <a class="remove_option btn btn-danger" data-remove-id="`+option_id+`"><i class="bi bi-trash"></i></a>
                </div>
                <div class="row mt-3">
                    <label class="form-label">قيم الاختيار:-</label> 
                    <div class="col-md-8 option_values_div">

                    </div> 
                </div>
            </div>
            `;
            $('.options').append(option_template);
        }

        $(document).on("click",".remove_option",function(e){
            e.preventDefault();
            var remove_id = $(this).attr("data-remove-id");
            $("#"+remove_id).fadeOut();
            $("#"+remove_id).remove();
            delete form_options_values[remove_id];
            update_from_options();
            const index = form_options_array.indexOf(remove_id);
            
            if (index > -1) {
                form_options_array.splice(index, 1);
            }
            if(form_options_array.length < 3){
                $("#add_option_btn").fadeIn();
            }
            var options_count = form_options_array.length;
            if(options_count === 0){
                $('#save_options_btn').fadeOut();
            }
        });

        const uid = function(){
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        }

        $(document).on("keypress",".option_values",function(e) {
            if(e.keyCode==13){
                e.preventDefault();
                var value = $(this).val();
                if(!value){
                    return false;
                }
                var option_id = $(this).attr('data-option-id');
                if(form_options_values[option_id]){
                    form_options_values[option_id].push(value);
                }else{
                    form_options_values[option_id] = [value];
                }
                $(this).val("");
                update_from_options();
            }
        });

        function update_from_options() {
            $('.option_values_div').html('')
            Object.keys(form_options_values).forEach(key => {
                form_options_values[key].forEach(value=>{
                    var template = `
                    <div 
                        class="remove_option_value hover-danger btn btn-success option_value_`+key+`" 
                        style="margin-left:10px" 
                        data-value="${value}"
                        data-option-id="${key}"
                    >
                        ${value}
                        <i class="bi bi-trash"></i>
                    </div>`
                    $('#'+key+' .option_values_div').append(template);
                });
            });
        }

        $(document).on("click",".remove_option_value",function(e){
            var option_id = $(this).attr("data-option-id");
            var value = $(this).attr("data-value");

            const index = form_options_values[option_id].indexOf(value);
            if (index > -1) {
                form_options_values[option_id].splice(index, 1);
            }
            update_from_options();
        })
        
        $(document).on("click","#save_options_btn",function(e){
            e.preventDefault();
            console.log(form_options_array);
            console.log(form_options_values);
        })

        $("#main_category_id").change(function () {
            var category_id = this.value;
            $("#sub_category_id").html('');
            $.ajax({
                type:'GET',
                url:`/api/categories/${category_id}/sub_categories`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $('#sub_category_id').html('<option value="">-- اختار التصنيف الفرعى --</option>');
                $.each(data, function (key, value) {
                    $("#sub_category_id").append('<option value="' + key + '">' + value + '</option>');
                });
            })
        })
    </script>
@endsection
