@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_marketers') }}">المسوقين</a></li>
                    <li><a class="link-dark" href="{{ route('edit_marketer',$marketer->id) }}">تعديل مسوق </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('update_marketer',$marketer->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل مسوق </h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $marketer->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            value="{{ $marketer->phone_number }}">
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> اسم الصفحة<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('page_name') is-invalid @enderror" name="page_name"
                            value="{{ $marketer->page_name }}">
                        @error('page_name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">لينك فيسبوك <i class="bi bi-facebook"> </i></label>
                        <input type="text" class="form-control" name="links[facebook]"
                            value="{{ json_decode($marketer->links)->facebook }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك انستجرام <i class="bi bi-instagram"> </i></label>
                        <input type="text" class="form-control" name="links[instagram]"
                            value="{{ json_decode($marketer->links)->instagram }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك تيك توك <i class="bi bi-tiktok"> </i></label>
                        <input type="text" class="form-control" name="links[tiktok]" value="{{ json_decode($marketer->links)->tiktok }}">
                    </div>
                </div>
                
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل مسوق <i
                        class="bi bi-person-fill-add"></i></button>
            </div>
        </form>
    </div>
    <script>
        $("#country-select").change(function () {
            var country_id = this.value;
            $("#city-select").html('');
            $.ajax({
                type:'GET',
                url:`/api/country/${country_id}/cities`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $('#city-select').html('<option value="">-- اختار المدينة --</option>');
                $.each(data, function (key, value) {
                    $("#city-select").append('<option value="' + key + '">' + value + '</option>');
                });
                
            })
        })
        $("#city-select").change(function () {
            var city_id = this.value;
            $("#area-select").html('');
            $.ajax({
                type:'GET',
                url:`/api/city/${city_id}/areas`,
                dataType: "text",
            }).then((response)=>{
                data = JSON.parse(response);
                $('#area-select').html('<option value="">-- اختار المنطقة --</option>');
                $.each(data, function (key, value) {
                    $("#area-select").append('<option value="' + key + '">' + value + '</option>');
                });
            })
        })
    </script>
@endsection
