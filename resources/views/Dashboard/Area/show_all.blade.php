@extends('layouts.app')

@section('title')
    {{ __('areas_title') }}
@endsection

@section('content')

<div class="modal fade" id="keywordsModal" tabindex="-1" aria-labelledby="keywordsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h3 class="my-3"> الكلمات الدلالية </h3>
                        <div class="options">
                            <div class="option mb-3 border shadow-sm p-3" id="1">
                                <div id="message" style="display: none"></div>
                                <div class="option_value_div">
                                    <label class="form-label"> الكلمة الدلالية <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control option_values mt-2 mb-3" data-option-id="1" placeholder="برجاء ادخال القيمة والضغط على زر enter">
                                    <div id="invalid-1" class="invalid-feedback">
                                        برجاء أضافة قيم الاختيار
                                    </div>
                                </div>

                                <div class="row mt-3 values_edit">
                                    <label class="form-label"> الكلمات الحالية:-</label>
                                    <div class="option_values_div">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="editKeywords">تعديل</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_sectors') }}">مناطق الشحن</a></li>
        </ul>
        @can('add', 'App\Models\Area')
        <div class="mt-2">
            <a href="{{ route('add_sector') }}"><button class="btn btn-primary">أضافة منطقة <i class="bi bi-map"></i></button></a>
        </div>
        @endcan
    </div>
    <div id="message" style="display: none"></div>
    <table class="table table-hover">
        <thead>
            <th>اسم المنطقة</th>
            <th>سعر الشحن</th>
            <th>محافظة</th>
            <th>شركة الشحن</th>
            <th> الكلمات الدلالية </th>
        </thead>
        <tbody>
            @foreach ($sectors as $sector)
            <tr>
                <td>{{ $sector->name }}</td>
                <td><input @cannot('edit_area', 'App\Models\Area' ) disabled @endcannot style="width: inherit;" class="form-control area_price" id="price_{{ $sector->id }}" data-id="{{ $sector->id }}" type="number" name="price" value="{{ $sector->price }}" /></td>
                <td>
                    <select @cannot('edit_area', 'App\Models\Area' ) disabled @endcannot class="form-select @error('city_id') is-invalid @enderror area_city" data-id="{{ $sector->id }}" id="city_{{ $sector->id }}" aria-label="Default select example" name="city_id">
                        <option value="">اختار</option>
                        @foreach ($cities as $id => $name)
                        <option @if ($id==$sector->city->id)
                            selected
                            @endif value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </td>
                <td>
                    <select @cannot('edit_area', 'App\Models\Area' ) disabled @endcannot class="form-select @error('shipping_company_id') is-invalid @enderror area_shipping_company" data-id="{{ $sector->id }}" id="shipping_company_{{ $sector->id }}" aria-label="Default select example" name="shipping_company_id">
                        <option value="">اختار</option>
                        @foreach ($shipping_companies as $shipping)
                        <option @if ($shipping->id == $sector->shipping_company->id)
                            selected
                            @endif value="{{ $shipping->id }}">{{ $shipping->name }}</option>
                        @endforeach
                    </select>
                    @error('shipping_company_id')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                    @enderror
                </td>
                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#keywordsModal" data-id="{{ $sector->id }}">عرض الكلمات الدلالية</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
<script>
    $(".area_price").change(function() {
        var token = $('#token').val();
        var price = $(this).val();
        var id = $(this).attr('data-id');
        if (confirm("هل تريد تغيير سعر الشحن؟")) {
            $.ajax({
                type: 'POST',
                url: `/api/sectors/${id}/edit`,
                dataType: "text",
                data: {
                    price,
                    token
                },
            }).then((response) => {
                $("#price_" + id).val(price);
            })
        } else {
            return false;
        }
    })
    $(".area_city").change(function() {
        $('#cityerror').remove();

        var token = $('#token').val();
        var city_id = $(this).val();
        var id = $(this).attr('data-id');
        if (city_id != '') {
            if (confirm("هل تريد تغيير المحافظة؟")) {
                $.ajax({
                    type: 'POST',
                    url: `/api/sectors/${id}/edit_city`,
                    dataType: "text",
                    data: {
                        city_id,
                        token
                    },
                }).then((response) => {
                    $("#area_" + id).val(city_id);
                })
            } else {
                return false;
            }
        } else {
            $('<span class="text-danger mt-1" id="cityerror">يجب الاختيار من القائمة</span>').insertAfter($(this));
        }
    });
    $(".area_shipping_company").change(function() {
        $('#shiperror').remove();

        var token = $('#token').val();
        var shipping_company_id = $(this).val();
        var id = $(this).attr('data-id');
        if (shipping_company_id != '') {
            if (confirm("هل تريد تغيير شركة الشحن؟")) {
                $.ajax({
                    type: 'POST',
                    url: `/api/sectors/${id}/edit_shipping_company`,
                    dataType: "text",
                    data: {
                        shipping_company_id,
                        token
                    },
                }).then((response) => {
                    $("#shipping_company_" + id).val(shipping_company_id);
                })
            } else {
                return false;
            }
        } else {
            $('<span class="text-danger mt-1" id="shiperror">يجب الاختيار من القائمة</span>').insertAfter($(this));
        }
    });

    // keywords of area.

    form_options_array = [];
    let form_options_values = new Object();

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
                class="remove_option_value hover-danger btn btn-success mb-3 option_value_` + key + `"
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

    $('#keywordsModal').on('show.bs.modal', function(e) {
        let id = $(e.relatedTarget).attr('data-id');
        $('#editKeywords').attr('data-id', id);
        $('.option_values_div').html("");
        form_options_values = new Object();

        $.ajax({
            url: `/api/area/${id}/get_keywords`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    if (value.trim() != '') {
                        if (form_options_values[1]) {
                            form_options_values[1].push(value);
                        } else {
                            form_options_values[1] = [value];
                        }

                        var template = `
                            <div
                                class="remove_option_value hover-danger btn btn-success option_value_` + (key + 1) + `"
                                style="margin-left:10px"
                                data-value="${value}"
                                data-option-id="${key + 1}"
                            >
                                ${value}
                                <i class="bi bi-trash"></i>
                            </div>`

                        $('.option_values_div').append(template);
                    }
                })
            },
            error: function() {

            }
        })
    })

    $('#editKeywords').on('click', function() {
        id = $(this).attr('data-id');
        var token = $('#token').val();
        keywords = Object.values(form_options_values)[0].join(" - ");
        $.ajax({
            type: 'POST',
            url: `/api/sectors/${id}/edit_keywords`,
            dataType: "json",
            data: {
                'keywords': keywords,
                'token': '@csrf',
            },
            success: function(data) {
                show_success(data);
            },
            error: function() {

            },
        });
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
</script>
@endsection
