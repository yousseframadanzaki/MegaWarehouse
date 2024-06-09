@extends('layouts.app')

@section('title')
    {{ __('add_client_groups_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_client_groups') }}">مجموعات العملاء</a></li>
                <li ><a href="{{route('add_client_group')}}" class="link-dark">اضافة مجموعة عملاء جديدة</a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_client_group') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">اضافة مجموعة عملاء جديدة</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم المجموعة</label>
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
                            <label for="formFile" class="form-label"> % خصم المجموعة</label>
                            <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" max="100"/>
                            
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة مجموعة <i
                        class="bi bi-plus-square-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
