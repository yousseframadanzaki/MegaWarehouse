@extends('layouts.app')

@section('title')
    {{ __('global.show_supplier_title') }}
@endsection

<style>
    label {
        font-weight: bold;
    }
</style>

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_suppliers') }}">الموردين</a></li>
                    <li><a class="link-dark" href="{{ route('show_supplier', ['supplier_id' => $supplier->id]) }}">عرض المورد </a></li>
                </ul>
        </div>

        <div class="row">
            <div class="card p-5 shadow-sm">
                <h1 class="text-center mt-3">
                    <img src="{{ asset($supplier->image->path ?? '') }}" class="rounded" style="width: 100px; height: 100px;">
                </h1>
                <div class="row mb-3 mt-4">
                    <div class="col-md-4">
                        <label class="form-label">الاسم </label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون </label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->phone }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان</label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->address }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"> عدد الفواتير </label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->invoices_count }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> مجموع الفواتير </label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->total_invoices - 0  }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> الرصيد </label>
                        <input type="text" class="form-control"
                            value="{{ $supplier->total_invoices - $supplier->user->total_transactions }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
