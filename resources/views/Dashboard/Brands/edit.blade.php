@extends('layouts.app')

@section('title')
    {{ __('edit_brand_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_brands') }}">الماركات</a></li>
                <li ><a class="link-dark"  href="{{ route('edit_brand',$brand->id) }}">تعديل ماركة </a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('edit_brand',$brand->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل ماركة </h1>
                <div>
                    <img src="{{asset($brand->logo->path ?? '')}}" width="200px"/>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $brand->name }}">
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
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل ماركة <i
                        class="bi bi-pencil-square"></i></button>
            </div>
        </form>
    </div>
@endsection
