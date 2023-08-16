@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_roles') }}">شركات الشحن</a></li>
                <li>اضافة شركة شحن جديدة</li>
            </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('store_shipping_company') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">اضافة شركة شحن جديدة</h1>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الشركة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الايميل او رقم تليفون</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">كلمة السر</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">لينك الشركة</label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror"
                            name="url" placeholder="ex: shipping-express.com" value="{{ old('url') }}">
                        @error('url')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة شركة الشحن <i
                        class="bi bi-truck"></i></button>
            </div>
        </form>

    </div>
@endsection