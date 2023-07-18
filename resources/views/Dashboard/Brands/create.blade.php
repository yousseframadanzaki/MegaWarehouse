@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_brands') }}">الماركات</a></li>
                <li ><a class="link-dark"  href="{{ route('add_brand') }}">اضافة ماركة جديدة</a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_brand') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة ماركة جديدة</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">لوجو الماركة</label>
                            <input class="form-control @error('logo') is-invalid @enderror" type="file" id="formFile"
                                name="logo">
                            @error('logo')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة ماركة <i
                        class="bi bi-plus-square-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
