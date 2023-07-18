@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
               <li><a href="{{ route('admin_dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_companies') }}">الشركات</a></li>
                <li><a class="link-dark" href="{{ route('edit_company',$company->id) }}"> تعديل {{$company->name}}</a></li>
            </ul>
        </div>
            <form class="row  needs-validation" novalidate action="{{route("update_company",$company->id)}}" method="POST">
                @csrf
                <div class="card p-5 shadow-sm">
                   <h1 class="text-center"></h1>
                   <h2>بيانات الشركة <i class="bi bi-building"></i></h2>
                   <div class="row mb-3">
                      <div class="col-md-6">
                         <label class="form-label">اسم الشركة</label>
                         <input type="text" class="form-control @error('company.name') is-invalid @enderror" name="name" value="{{$company->name}}">
                         @error('company.name')
                            <div class="invalid-feedback">
                                  {{__($message)}}
                            </div>
                         @enderror
                      </div>
                      <div class="col-md-6">
                         <label class="form-label">نوع الشركة</label>
                         <input type="text" class="form-control @error('company.company_type') is-invalid @enderror" name="company_type" value="{{$company->company_type}}">
                         @error('company.company_type')
                            <div class="invalid-feedback">
                                  {{__($message)}}
                            </div>
                         @enderror
                      </div>
                   </div>
                   <div class="row">
                      <div class="col-md-6">
                         <label class="form-label">اقصى عدد الاعضاء</label>
                         <input type="number" class="form-control @error('company.max_users') is-invalid @enderror" name="max_users" value="{{$company->max_users}}">
                         @error('company.max_users')
                            <div class="invalid-feedback">
                                  {{__($message)}}
                            </div>
                         @enderror
                      </div>
                      <div class="col-md-6">
                         <label class="form-label">اقصى عدد الاوردرات</label>
                         <input type="number" class="form-control @error('company.max_orders') is-invalid @enderror" name="max_orders" value="{{$company->max_orders}}">
                         @error('company.max_orders')
                            <div class="invalid-feedback">
                                  {{__($message)}}
                            </div>
                         @enderror
                      </div>
                   </div>

                <button class="btn btn-lg btn-primary mt-3 shadow-sm">تعديل الشركة <i class="bi bi-building-fill-add"></i></button>
                </div>
             </form>
        </div>
@endsection
