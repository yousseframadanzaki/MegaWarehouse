@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_categories') }}">التصنيفات</a></li>
                <li ><a href="{{route('add_category')}}" class="link-dark">اضافة تصنيف جديد</a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('store_category') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">اضافة تصنيف جديد</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم التصنيف</label>
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
                            <label for="formFile" class="form-label">التصنيف الاب</label>
                            <select class="form-select" aria-label="Default select example" name="parent_id">
                                <option value="">بدون تصنيف</option>
                                @foreach ($categories as $cat)
                                   <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                             </select>
                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة تصنيف <i
                        class="bi bi-plus-square-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
