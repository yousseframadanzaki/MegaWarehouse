@extends('layouts.app')

@section('title')
    {{ __('global.edit_shipping_company_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_shipping_companies') }}">شركات الشحن</a></li>
                <li>تعديل شركة شحن </li>
            </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('update_shipping_company',$shipping_company->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل شركة شحن </h1>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الشركة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $shipping_company->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الايميل او رقم تليفون</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ $shipping_company->username }}">
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
                            name="password" value="{{ $shipping_company->password }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label">تأكيد كلمة السر </label>
                        <input type="password" class="form-control @error('password2') is-invalid @enderror" name="password2" value="{{ $shipping_company->password }}">
                        @error('password2')
                           <div class="invalid-feedback">
                                 {{__($message)}}
                           </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">لينك الشركة</label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror"
                            name="url" placeholder="ex: shipping-express.com" value="{{ $shipping_company->url }}">
                        @error('url')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل شركة الشحن <i
                        class="bi bi-truck"></i></button>
            </div>
        </form>

    </div>
@endsection
