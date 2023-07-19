@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_suppliers') }}">الموردين</a></li>
                    <li><a class="link-dark" href="{{ route('edit_supplier',$supplier->id) }}">تعديل مورد  </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('update_supplier',$supplier->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل مورد </h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $supplier->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ $supplier->phone }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">عنوان <span class="text-danger">*</span><i class="bi bi-map-marker">
                            </i></label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            value="{{ $supplier->address }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل مورد <i
                        class="bi bi-person-fill-add"></i></button>
            </div>
        </form>
    </div>
@endsection
