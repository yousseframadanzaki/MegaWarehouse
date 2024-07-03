@extends('layouts.app')

@section('title')
    {{ __('global.edit_client_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_clients') }}">العملاء</a></li>
                    <li><a class="link-dark" href="{{ route('edit_client',$client->id) }}">تعديل عميل </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('update_client',$client->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل عميل </h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $client->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone_1') is-invalid @enderror" name="phone_1"
                            value="{{ $client->phone_1 }}">
                        @error('phone_1')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">رقم التليفون 2 </label>
                        <input type="text" class="form-control @error('phone_2') is-invalid @enderror" name="phone_2"
                            value="{{ $client->phone_2 }}">
                        @error('phone_2')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">عنوان <span class="text-danger">*</span><i class="bi bi-map-marker">
                            </i></label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            value="{{ $client->address }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"> الدولة <span class="text-danger">*</span></label>
                        <select id="country-select" class="form-select @error('country_id') is-invalid @enderror" aria-label="Default select example" name="country_id">
                            <option value="">اختار</option>
                            @foreach ($countries as $id => $name)
                                <option @if($client->country_id == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المدينة <span class="text-danger">*</span></label>
                        <select id="city-select" class="form-select @error('city_id') is-invalid @enderror" aria-label="Default select example" name="city_id">

                            @foreach ($cities as $id => $name)
                                <option @if($client->city_id == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label ">المنطقة <span class="text-danger">*</span></label>
                        <select id="area-select" class="form-select @error('area_id') is-invalid @enderror" aria-label="Default select example" name="area_id">
                            @foreach ($areas as $area)
                                <option @if($client->area_id == $area->id) selected @endif value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        @error('area_id')
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
                            value="{{ $client->links->facebook }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك انستجرام <i class="bi bi-instagram"> </i></label>
                        <input type="text" class="form-control" name="links[instagram]"
                            value="{{ $client->links->instagram }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">لينك تيك توك <i class="bi bi-tiktok"> </i></label>
                        <input type="text" class="form-control" name="links[tiktok]" value="{{ $client->links->tiktok }}">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <label class="form-label">مجموعة العملاء</label>
                        <select class="form-select" aria-label="Default select example" name="client_group_id">
                            <option value="">اختار مجموعة عملاء</option>
                            @foreach ($client_groups as $id => $name)
                                <option @if($client->client_group_id == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('client_group_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <p class="mt-3"><span class="text-danger">*</span> حقل اجبارى</p>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل عميل <i
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
                    $("#area-select").append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            })
        })
    </script>
@endsection
