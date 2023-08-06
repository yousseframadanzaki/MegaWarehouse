@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
                <li><a class="link-dark" href="{{ route('add_order') }}">اضافة اوردر جديد </a></li>
            </ul>
        </div>

        <div class="card p-3">
            <div class="row">
                <h1 class="text-center">أضافة اوردر جديد</h1>
                <div class="row">
                    <h4>بيانات العميل</h4>
                    <div class="col-md-4">
                        <label class="form-label">الاسم </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون</label>
                        {{-- <select class="form-select" name="client_id">
                            <option value="">اختار العميل</option>
                            @foreach ($clients as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select> --}}
                        <input type="text" name="phone_1" list="phone_numbers" class="form-control" autocomplete="off" placeholder="يمكنك البحث عن عميل برقم الهاتف">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون 2 </label>
                        <input type="text" class="form-control @error('phone_2') is-invalid @enderror" name="phone_2"
                            value="{{ old('phone_2') }}">
                        @error('phone_2')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">عنوان <i class="bi bi-map-marker">
                            </i></label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label"> الدولة </label>
                        <select id="country-select" class="form-select @error('country_id') is-invalid @enderror"
                            aria-label="Default select example" name="country_id">
                            <option value="">اختار</option>
                            @foreach ($countries as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المدينة </label>
                        <select id="city-select" class="form-select @error('city_id') is-invalid @enderror"
                            aria-label="Default select example" name="city_id">


                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label ">المنطقة </label>
                        <select id="area-select" class="form-select @error('area_id') is-invalid @enderror"
                            aria-label="Default select example" name="area_id">

                        </select>
                        @error('area_id')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-5">
                    <h4>المنتجات</h4>
                    <div>
                        <a href="" class="btn btn-lg btn-primary">أضافة منتج الى طلب</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <datalist id="phone_numbers">
        @foreach ($clients as $client)
            <option value="{{ $client->phone_1 }}">{{ $client->phone_1 }}</option>
        @endforeach
    </datalist>
@endsection
