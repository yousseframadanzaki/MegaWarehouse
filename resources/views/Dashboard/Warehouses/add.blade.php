@extends('layouts.app')

@section('title')
    {{ __('global.add_warehouse_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_warehouses') }}">المخازن</a></li>
                <li><a class="link-dark" href="{{ route('add_warehouse') }}">اضافة مخزن جديد </a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_warehouse') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة مخزن جديد</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة مخزن <i
                        class="bi bi-building-add"></i></button>
            </div>
        </form>
    </div>
@endsection
