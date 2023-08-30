@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin_dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_companies') }}">الشركات</a></li>
                <li>اضافة شركة جديدة</li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_company') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة شركة جديدة</h1>
                <h2>بيانات الشركة <i class="bi bi-building"></i></h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الشركة</label>
                        <input type="text" class="form-control @error('company.name') is-invalid @enderror"
                            name="company[name]" value="{{ old('company.name') }}">
                        @error('company.name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الشركة</label>
                        <input type="text" class="form-control @error('company.company_type') is-invalid @enderror"
                            name="company[company_type]" value="{{ old('company.company_type') }}">
                        @error('company.company_type')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">اقصى عدد الاعضاء</label>
                        <input type="number" class="form-control @error('company.max_users') is-invalid @enderror"
                            name="company[max_users]" value="{{ old('company.max_users') }}">
                        @error('company.max_users')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اقصى عدد الاوردرات</label>
                        <input type="number" class="form-control @error('company.max_orders') is-invalid @enderror"
                            name="company[max_orders]" value="{{ old('company.max_orders') }}">
                        @error('company.max_orders')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">كود الشركة</label>
                        <input type="text" class="form-control @error('company.code') is-invalid @enderror"
                            name="company[code]" value="{{ old('company.code') }}">
                        @error('company.code')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم المخزن الرئيسى</label>
                        <input type="text" class="form-control @error('warehouse.name') is-invalid @enderror"
                            name="warehouse[name]" value="{{ old('warehouse.name') }}">
                        @error('warehouse.name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <h2 class="mt-5">بيانات owner <i class="bi bi-person-fill"></i></h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control @error('user.name') is-invalid @enderror"
                            name="user[name]" value="{{ old('user.name') }}">
                        @error('user.name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الايميل</label>
                        <input type="text" class="form-control @error('user.email') is-invalid @enderror"
                            name="user[email]" value="{{ old('user.email') }}">
                        @error('user.email')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">رقم التليفون</label>
                        <input type="text" class="form-control @error('user.phone_1') is-invalid @enderror"
                            name="user[phone_1]" value="{{ old('user.phone_1') }}">
                        @error('user.phone_1')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">كلمة السر</label>
                        <input type="password" class="form-control @error('user.password') is-invalid @enderror"
                            name="user[password]" value="{{ old('user.password') }}">
                        @error('user.password')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة الشركة <i
                        class="bi bi-building-fill-add"></i></button>
            </div>
        </form>
    </div>
@endsection
