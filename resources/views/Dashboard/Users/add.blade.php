@extends('layouts.app')

@section('title')
    {{ __('global.add_user_title') }}
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
      <li><a href="{{route('dashboard')}}">@lang('global.dashboard')</a></li>
      <li><a href="{{route('all_users')}}">@lang('global.Users')</a></li>
      <li>@lang('global.addition_new_user')</li>
   </ul>
</div>
   <form class="row  needs-validation" novalidate action="{{route("store_user")}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card p-5 shadow-sm">
         <h1 class="text-center mb-4">@lang('global.addition_new_user')</h1>
         <div class="row my-0">
            <div class="col-md-6 mb-3">
               <label class="form-label">@lang('global.user_name')</label>
               <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" >
               @error('name')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
               <label class="form-label">@lang('global.email')</label>
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
               <label  class="form-label">@lang('global.phone_1')</label>
               <input type="text" class="form-control @error('phone_1') is-invalid @enderror" name="phone_1" value="{{old('phone_1')}}">
               @error('phone_1')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label  class="form-label">@lang('global.role_id')</label>
                <select class="form-select" aria-label="Default select example" name="role_id">
                   <option value="">@lang('global.select_role')</option>
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
                <label  class="form-label">@lang('global.password')</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                @error('password')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label  class="form-label">@lang('global.password_confirmation')</label>
                <input type="password" class="form-control @error('password2') is-invalid @enderror" name="password2">
                @error('password2')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
               <label  class="form-label">@lang('global.warehouse_id')</label>
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
                  <label for="formFile" class="form-label">@lang('global.image')</label>
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
            <button class="btn btn-lg btn-primary my-3 shadow-sm">@lang('global.button_add')<i class="bi bi-person-fill-add"></i></button>
         </div>
     </div>
   </form>
</div>

@endsection
