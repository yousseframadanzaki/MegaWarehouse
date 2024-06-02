@extends('layouts.app')

@section('content')



<div class="p-3">
   <div class="row">
   <ul class="breadcrumb">
      <li><a href="{{route('dashboard')}}">الرئيسية</a></li>
      <li><a href="{{route('all_transactions')}}">عرض العمليات المالية</a></li>
      <li>اضافة عملية مالية</li>
   </ul>
</div>
   <form class="row  needs-validation" novalidate action="" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card p-5 shadow-sm">
         <h1 class="text-center">إضافة عملية مالية</h1>
         <div class="row mb-3 mt-3">
            <div class="col-md-6">
               <label class="form-label">القيمة</label>
               <input type="text" class="form-control @error('name') is-invalid @enderror" name="value" value="{{old('value')}}" >
               @error('name')
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
         </div>
         <div class="row mb-3">
            <div class="col-md-6">
               <label  class="form-label">تصنيف العمليات</label>
               <select class="form-select" aria-label="Default select example" name="payment_category" id="payment_category">
                  <option value="">اختار التصنيف ...</option>
                  @foreach ($payment_categories as $name)
                     <option value="{{$name}}">{{$name}}</option>
                  @endforeach
               </select>
               @error('payment_category')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
               <label  class="form-label">نوع العملية</label>
               <select class="form-select" aria-label="Default select example" name="payment_id" id="payment_id">
                <option>اختار نوع العملية ...</option>
               </select>
               @error('payment_id')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         {{-- <div class="row">
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
         </div> --}}
      <button class="btn btn-lg btn-primary mt-3 shadow-sm"> إضافة عملية مالية <i class="bi bi-plus"></i></button>
      </div>
   </form>
</div>

@endsection

@section('script')
    <script>
        $('#payment_category').on('change', function() {
            category = $(this).val();
            $.ajax({
                url: `/api/category/${category}/payment_types`,
                method: 'get',
                success: function(response) {
                    $('#payment_id').empty();
                    $('#payment_id').append('<option>اختار نوع العملية ...</option>')
                    $.each(response, function(key, value) {
                        $('#payment_id').append(`<option value="${key}">${value}</option>`)
                    })
                },
                error: function() {

                }
            })
        })
    </script>
@endsection
