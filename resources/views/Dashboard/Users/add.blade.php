@extends('layouts.app')

@section('title')
    {{ __('add_user_title') }}
@endsection

@section('content')

<style>
    label {
        font-weight: bold;
    }
</style>

<div class="p-3">
   <div class="row">
   <ul class="breadcrumb">
      <li><a href="{{route('dashboard')}}">الرئيسية</a></li>
      <li><a href="{{route('all_users')}}">الاعضاء</a></li>
      <li>اضافة عضو جديد</li>
   </ul>
</div>
   <form class="row  needs-validation" novalidate action="{{route("store_user")}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card p-5 shadow-sm">
         <h1 class="text-center mb-4">إضافة عضو جديد</h1>
         <div class="row my-0">
            <div class="col-md-6 mb-3">
               <label class="form-label">الاسم</label>
               <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" >
               @error('name')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
               <label class="form-label">الايميل</label>
               <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
               @error('email')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row my-0">
            <div class="col-md-6 mb-3">
               <label  class="form-label">رقم التليفون</label>
               <input type="text" class="form-control @error('phone_1') is-invalid @enderror" name="phone_1" value="{{old('phone_1')}}">
               @error('phone_1')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label  class="form-label">الادارة</label>
                <select class="form-select" aria-label="Default select example" name="role_id">
                   <option value="">أختار الاداره</option>
                   @foreach ($roles as $id => $name)
                      <option value="{{$id}}">{{$name}}</option>
                   @endforeach
                </select>
                @error('role')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
         </div>
         <div class="row my-0">
            <div class="col-md-6 mb-3">
                <label  class="form-label">كلمة السر</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}">
                @error('password')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label  class="form-label">تأكيد كلمة السر </label>
                <input type="password" class="form-control @error('password2') is-invalid @enderror" name="password2" value="{{old('password2')}}">
                @error('password2')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
               <label  class="form-label">المخزن</label>
               <select class="form-select" aria-label="Default select example" name="warehouse_id">
                  @foreach ($warehouses as $id => $name)
                     <option value="{{$id}}">{{$name}}</option>
                  @endforeach
               </select>
               @error('role')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row my-0">
            <div class="col-md-6 mb-3">
               <div class="mb-3">
                  <label for="formFile" class="form-label">صورة العضو</label>
                  <input class="form-control @error('image') is-invalid @enderror" type="file" id="formFile" name="image">
                  @error('image')
                     <div class="invalid-feedback">
                           {{__($message)}}
                     </div>
                  @enderror
                </div>
            </div>
         </div>
         <div class="w-50 text-center mx-auto">
            <button class="btn btn-lg btn-primary my-3 shadow-sm">إضافة عضو <i class="bi bi-person-fill-add"></i></button>
         </div>  
     </div>
   </form>
</div>

@endsection