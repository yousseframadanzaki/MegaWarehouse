@extends('layouts.app')

@section('title')
    {{ __('add_role_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_roles') }}">الادارات</a></li>
                <li>اضافة ادارة جديدة</li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_role') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة ادارة جديدة</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الادارة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الادارة</label>
                        <select class="form-select form-select @error('type')is-invalid @enderror" name="user_type_id" id="">
                            <option selected>اختار نوع</option>
                            <option @if(old('type') == '1') selected @endif value="1">أعضاء ادارة</option>
                            <option @if(old('type') == '2') selected @endif value="2">موردين</option>
                            <option @if(old('type') == '3') selected @endif value="3">مسوقين</option>
                            <option @if(old('type') == '4') selected @endif value="4">شركة شحن</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                @error('permissions')
                    <p class="text-danger">
                        {{ __($message) }}
                    </p>
                @enderror
                @foreach ($permission_classes as $permission_class)
                    <div class="row mt-5">
                        <h1>{{ __($permission_class[0]->resource_name) }}</h1>
                        @foreach ($permission_class as $permission)
                            <div class="form-check col-md-4" style="direction: rtl">
                                <input name="permissions[]" class="form-check-input fs-3" style="float: right;"
                                    type="checkbox" value="{{ $permission->id }}" id="flexCheck-{{ $permission->id }}">
                                <label class="form-check-label fs-3" for="flexCheck-{{ $permission->id }}"
                                    style="margin-right: 30px;">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة ادارة <i
                        class="bi bi-clipboard2-plus"></i></button>
            </div>
        </form>
    </div>
@endsection
