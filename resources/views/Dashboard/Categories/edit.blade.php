@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_categories') }}">التصنيفات</a></li>
                <li ><a href="{{route('edit_category',$category->id)}}" class="link-dark">تعديل تصنيف </a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('update_category',$category->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل تصنيف </h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم التصنيف</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $category->name }}">
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
                                @foreach ($categories as $id => $name)
                                   @if($category->id != $id)
                                    <option @if($category->parent_id === $id) selected @endif value="{{$id}}">{{$name}}</option>
                                   @endif                                
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
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل تصنيف <i
                        class="bi bi-plus-square-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
