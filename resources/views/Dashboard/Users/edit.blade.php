@extends('layouts.app')
 
@section('content')


<div class="p-3">
   <div class="row">
   <ul class="breadcrumb">
      <li><a href="{{route('dashboard')}}">الرئيسية</a></li>
      <li><a href="{{route('all_users')}}">الاعضاء</a></li>
      <li><a class="link-dark" href="{{route('user_edit',$user->id)}}">تعديل عضو {{$user->name}}</a></li>
   </ul>
</div>
   <form class="row  needs-validation" novalidate action="{{route("store_user")}}" method="POST">
      @csrf
      <div class="card p-5 shadow-sm">
         <h1 class="text-center">تعديل عضو </h1>
         <div class="row mb-3 mt-3">
            <div class="col-md-6">
               <label class="form-label">الاسم</label>
               <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" >
               @error('name')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
               <label class="form-label">الايميل</label>
               <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}">
               @error('email')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <label  class="form-label">رقم التليفون</label>
               <input type="text" class="form-control @error('phone_1') is-invalid @enderror" name="phone_1" value="{{$user->phone_1}}">
               @error('phone_1')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
               <label  class="form-label">كلمة السر</label>
               <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
               @error('password')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
      <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل عضو <i class="bi bi-person-fill-add"></i></button>
      </div>
   </form>
</div>

@endsection