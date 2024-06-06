@extends('layouts.app')
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('add_points') }}">اضافة نقاط</a></li>
        </ul>
    </div>
    <div id="message" style="display: none"></div>
    <form class="row  needs-validation" novalidate action="{{ route('store_whatsapp_points') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-5 shadow-sm">
           <h1 class="text-center mb-5">إضافة نقاط الواتس اب للاأعضاء</h1>
           <div class="row mb-3">
              <div class="col-md-6">
                 <label  class="form-label">الأعضاء</label>
                 <select class="form-select @error('user') is-invalid @enderror" aria-label="Default select example" name="user_id" id="user_id">
                    <option value="">اختار العضو</option>
                    @foreach ($users as $id => $name)
                       <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                 </select>
                 @error('user')
                    <div class="invalid-feedback">
                          {{__($message)}}
                    </div>
                 @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">رصيد نقاط الواتس اب:</label>
                <select class="form-select @error('whatsapp_points') is-invalid @enderror" aria-label="Default select example" name="points" id="whatsapp_points">
                    <option value=""> اختر الباقة </option>
                    <option value="3000">باقة 3000 رسالة = 200 جنيه</option>
                    <option value="10000">باقة 10000 رسالة = 500 جنيه</option>
                    <option value="30000">باقة 30000 رسالة = 1000 جنيه</option>
                </select>
                @error('whatsapp_points')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
             </div>
           </div>
           <div class="col-md-6">
            <label class="form-label">ملاحظة </label>
            <textarea class="form-control @error('note') is-invalid @enderror" name="note"></textarea>
            @error('note')
               <div class="invalid-feedback">
                     {{__($message)}}
               </div>
            @enderror
         </div>
        <button class="btn btn-lg btn-primary mt-3 shadow-sm"> إضافة نقاط <i class="bi bi-plus"></i></button>
        </div>
     </form>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $('#user_id').select2();
    $('#whatsapp_points').select2();
    
</script>
@endsection