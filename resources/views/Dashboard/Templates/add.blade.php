@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_templates') }}">نصوص</a></li>
                    <li><a class="link-dark" href="{{ route('add_template') }}">اضافة نص جديد </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" novalidate action="{{ route('store_template') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة نص جديد</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-8">
                        <label class="form-label">النص <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('text') is-invalid @endif" name="text" id="" rows="3">{{old('text')}}</textarea>
                       
                        @error('text')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">نوع النص <span class="text-danger">*</span></label>
                        <select class="form-select form-select @error('type') is-invalid @endif" name="type" id="">
                            <option selected value="">اختار النوع</option>
                            <option @if(old('type') == 'orders')selected @endif value="orders">نصوص الاوردرات</option>
                            <option @if(old('type') == 'clients')selected @endif value="clients">نصوص العملاء</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة نص <i
                        class="bi bi-person-fill-add"></i></button>
            </div>
        </form>
    </div>
@endsection
