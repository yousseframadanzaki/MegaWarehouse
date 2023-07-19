@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a  href="{{ route('all_client_groups') }}">مجموعات العملاء</a></li>
                <li ><a href="{{route('edit_client_group',$client_group->id)}}" class="link-dark">تعديل مجموعة عملاء </a></li>
            </ul>
        </div>
        <form class="row  needs-validation" novalidate action="{{ route('update_client_group',$client_group->id) }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">تعديل مجموعة عملاء </h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم المجموعة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $client_group->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label"> % خصم المجموعة</label>
                            <input value="{{$client_group->discount}}" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" max="100"/>
                            
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ __($message) }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل مجموعة <i
                        class="bi bi-plus-square-fill"></i></button>
            </div>
        </form>
    </div>
@endsection
