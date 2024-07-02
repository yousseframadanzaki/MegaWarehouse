@extends('layouts.app')

@section('title')
    {{ __('add_area_title') }}
@endsection

@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_sectors') }}">مناطق الشحن</a></li>
            <li><a class="link-dark" href="{{ route('add_sector') }}">اضافة منطقة</a></li>
        </ul>
    </div>
    <div id="message" style="display: none"></div>
    <form class="row  needs-validation" action="{{ route('store_sector') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-5 shadow-sm">
            <h1 class="text-center">أضافة منطقة جديدة</h1>
            <div class="row mb-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">اسم المنطقة</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">سعر الشحن</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}">
                    @error('price')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">المدينة</label>
                    <select class="form-select @error('city_id') is-invalid @enderror" aria-label="Default select example" name="city_id">
                        <option value="">اختار</option>
                        @foreach ($cities as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">شركة الشحن</label>
                    <select class="form-select @error('shipping_company_id') is-invalid @enderror" aria-label="Default select example" name="shipping_company_id">
                        <option value="">اختار</option>
                        @foreach ($shipping_companies as $shipping)
                        <option value="{{ $shipping->id }}">{{ $shipping->name }}</option>
                        @endforeach
                    </select>
                    @error('shipping_company_id')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </div>
                <div class="col-12 my-3">
                    <h3 class="my-3"> الكلمات الدلالية </h3>
                    <div class="options">
                        <div class="option row mb-3 border shadow-sm p-3" id="1">
                            <div class="col-md-5 option_value_div">
                                <label class="form-label"> الكلمة الدلالية <span class="text-danger">*</span></label>
                                <input type="text" class="form-control option_values" data-option-id="1" placeholder="برجاء ادخال القيمة والضغط على زر enter">
                                <div id="invalid-1" class="invalid-feedback">
                                    برجاء أضافة قيم الاختيار
                                </div>

                                <input type="hidden" name="keywords">
                            </div>
                            <!-- <div class="col-md-2 d-md-flex align-items-end">
                                <a class="remove_option btn btn-danger" data-remove-id="` + option_id + `"><i class="bi bi-trash"></i></a>
                            </div> -->
                            <div class="row mt-3 values_edit">
                                <label class="form-label"> الكلمات التي سيتم إضافتها:-</label>
                                <div class="option_values_div">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة منطقة <i class="bi bi-map"></i></button>
            </div>
    </form>
</div>
@endsection

@section('script')
<script>
    form_options_array = [];
    form_options_values = new Object();

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

    $('form').on('submit', function(e) {
        e.preventDefault();
        if (Object.values(form_options_values).length > 0)
            $('input[name=keywords]').val(Object.values(form_options_values)[0].join(" - "));
        this.submit();
    })
</script>
@endsection
