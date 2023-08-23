@extends('layouts.app')
 
@section('content')



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
         <h1 class="text-center">أضافة عضو جديد</h1>
         <div class="row mb-3 mt-3">
            <div class="col-md-6">
               <label class="form-label">الاسم</label>
               <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" >
               @error('name')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
               <label class="form-label">الايميل</label>
               <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
               @error('email')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-md-6">
               <label  class="form-label">رقم التليفون</label>
               <input type="text" class="form-control @error('phone_1') is-invalid @enderror" name="phone_1" value="{{old('phone_1')}}">
               @error('phone_1')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
               <label  class="form-label">كلمة السر</label>
               <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}">
               @error('password')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-md-6">
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
            <div class="col-md-6">
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
         <div class="row">
            <div class="col-md-6">
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
      <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة عضو <i class="bi bi-person-fill-add"></i></button>
      </div>
   </form>
</div>

@endsection