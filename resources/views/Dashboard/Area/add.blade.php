@extends('layouts.app')
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
    <form class="row  needs-validation" novalidate action="{{ route('store_sector') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="card p-5 shadow-sm">
        <h1 class="text-center">أضافة منطقة جديدة</h1>
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <label class="form-label">اسم المنطقة</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">سعر الشحن</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                    value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">
                        {{ __($message) }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                    <label class="form-label">المدينة</label>
                <select class="form-select @error('city_id') is-invalid @enderror"
                    aria-label="Default select example" name="city_id">
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
                <select class="form-select @error('shipping_company_id') is-invalid @enderror"
                    aria-label="Default select example" name="shipping_company_id">
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
        <button type="submit" class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة منطقة <i
                class="bi bi-map"></i></button>
    </div>
</form>
</div>
@endsection
