@extends('layouts.app')
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_sectors') }}">مناطق الشحن</a></li>
        </ul>
        <div class="mt-2">
            <a href="{{ route('add_sector') }}"><button class="btn btn-primary">أضافة منطقة <i class="bi bi-map"></i></button></a>
        </div>
    </div>
    <div id="message" style="display: none"></div>
    <table class="table table-hover">
        <thead>
            <th>اسم المنطقة</th>
            <th>سعر الشحن</th>
            <th>محافظة</th>
            <th>شركة الشحن</th>
        </thead>
        <tbody>
            @foreach ($sectors as $sector)
            <tr>
                <td>{{ $sector->name }}</td>
                <td><input style="width: inherit;" class="form-control area_price" id="price_{{ $sector->id }}"
                    data-id="{{ $sector->id }}" type="number" name="price"
                    value="{{ $sector->price }}"/></td>
                <td>
                    <select class="form-select @error('city_id') is-invalid @enderror area_city" data-id="{{ $sector->id }}" id="city_{{ $sector->id }}"
                        aria-label="Default select example" name="city_id">
                        <option value="">اختار</option>
                        @foreach ($cities as $id => $name)
                            <option @if ($id == $sector->city->id)
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
                    <select class="form-select @error('shipping_company_id') is-invalid @enderror area_shipping_company" data-id="{{ $sector->id }}" id="shipping_company_{{ $sector->id }}"
                        aria-label="Default select example" name="shipping_company_id">
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
        if(confirm("هل تريد تغيير سعر الشحن؟")) {
            $.ajax({
                type: 'POST',
                url: `/api/sectors/${id}/edit`,
                dataType: "text",
                data: { price,token },
            }).then((response) => {
                $("#price_" + id).val(price);
            })
        } else {
            return false;
        }
    })
    $(".area_city").change(function(){
        var token = $('#token').val();
        var city_id = $(this).val();
        var id = $(this).attr('data-id');
        if(confirm("هل تريد تغيير المحافظة؟")) {
            $.ajax({
                type: 'POST',
                url: `/api/sectors/${id}/edit_city`,
                dataType: "text",
                data: { city_id,token },
            }).then((response) => {
                $("#area_" + id).val(city_id);
            })
        } else {
            return false;
        }
    });
    $(".area_shipping_company").change(function(){
        var token = $('#token').val();
        var shipping_company_id = $(this).val();
        var id = $(this).attr('data-id');
        if(confirm("هل تريد تغيير شركة الشحن؟")) {
            $.ajax({
                type: 'POST',
                url: `/api/sectors/${id}/edit_shipping_company`,
                dataType: "text",
                data: { shipping_company_id,token },
            }).then((response) => {
                $("#shipping_company_" + id).val(shipping_company_id);
            })
        } else {
            return false;
        }
    });
</script>
@endsection
