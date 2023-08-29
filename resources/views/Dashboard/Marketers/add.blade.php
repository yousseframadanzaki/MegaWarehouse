@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_marketers') }}">المسوقين</a></li>
                    <li><a class="link-dark" href="{{ route('add_marketer') }}">اضافة مسوق جديد </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('store_marketer') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة مسوق جديد</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">اسم الصفحة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('page_name') is-invalid @enderror" name="page_name"
                            value="{{ old('page_name') }}">
                        @error('page_name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label  class="form-label">الادارة</label>
                        <select class="form-select @error('role_id') is-invalid @enderror" aria-label="Default select example" name="role_id">
                           <option value="">أختار الاداره</option>
                           @foreach ($roles as $id => $name)
                              <option value="{{$id}}">{{$name}}</option>
                           @endforeach
                        </select>
                        @error('role_id')
                           <div class="invalid-feedback">
                                 {{__($message)}}
                           </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الايميل <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">كلمة السر <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">لينك فيسبوك <i class="bi bi-facebook"> </i></label>
                        <input type="text" class="form-control" name="links[facebook]"
                            value="{{ old('links[facebook]') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك انستجرام <i class="bi bi-instagram"> </i></label>
                        <input type="text" class="form-control" name="links[instagram]"
                            value="{{ old('links[instagram]') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك تيك توك <i class="bi bi-tiktok"> </i></label>
                        <input type="text" class="form-control" name="links[tiktok]" value="{{ old('links[tiktok]') }}">
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة مسوق <i
                        class="bi bi-person-fill-add"></i></button>
            </div>
        </form>
    </div>
@endsection
@section('script')
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
