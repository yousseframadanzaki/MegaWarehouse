@extends('layouts.app')

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
      <li><a href="{{route('all_transactions')}}">عرض العمليات المالية</a></li>
      <li>اضافة عملية مالية</li>
   </ul>
</div>
   <form class="row  needs-validation" novalidate action="{{ route('store_transaction') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card p-5 shadow-sm">
         <h1 class="text-center mb-5">إضافة عملية مالية</h1>
         <div class="row mb-3">
            <div class="col-md-6">
               <label  class="form-label">تصنيف العملية</label>
               <select class="form-select @error('payment_category') is-invalid @enderror" aria-label="Default select example" name="payment_category" id="payment_category">
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
               <select class="form-select @error('payment_type_id') is-invalid @enderror" aria-label="Default select example" name="payment_type_id" id="payment_type_id">
                <option>اختار نوع العملية ...</option>
               </select>
               @error('payment_type_id')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
         </div>
         <div class="row mb-3 mt-3">
            <div class="col-md-6">
               <label class="form-label">القيمة</label>
               <input type="number" class="form-control @error('value') is-invalid @enderror" name="value" value="{{old('value')}}" >
               @error('value')
                  <div class="invalid-feedback">
                        {{__($message)}}
                  </div>
               @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">الملاحظات </label>
                <input type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{old('note')}}" >
                @error('note')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
             </div>
         </div>
         <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <label  class="form-label"> من </label>
                <select id="from" class="form-select @error('from') is-invalid @enderror" aria-label="Default select example" name="from" id="from">
                    <option>  من ...</option>
                    @foreach ($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                    </select>
                @error('from')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label  class="form-label"> إلي </label>
                <select id="to" class="form-select @error('to') is-invalid @enderror" aria-label="Default select example" name="to" id="to">
                    <option>  إلي ...</option>
                    @foreach ($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('to')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
             </div>
         </div>

      <button class="btn btn-lg btn-primary mt-3 shadow-sm"> إضافة عملية مالية <i class="bi bi-plus"></i></button>
      </div>
   </form>
</div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('select').select2();

        $('#payment_category').on('change', function() {
            category = $(this).val();
            $.ajax({
                url: `/api/category/${category}/payment_types`,
                method: 'get',
                success: function(response) {
                    $('#payment_type_id').empty();
                    $('#payment_type_id').append('<option>اختار نوع العملية ...</option>')
                    $.each(response, function(key, value) {
                        $('#payment_type_id').append(`<option value="${key}">${value}</option>`)
                    })
                },
                error: function() {

                }
            })
        })

        $('#from, #to').on('change', function() {
            if ($(this).val() == '') {
                $('#to option').removeAttr('disabled');
                $('#from option').removeAttr('disabled');
            } else if ($(this).attr('id') == 'from') {
                $(`#to option`).removeAttr('disabled');
                $(`#to option[value=${ $(this).val() }]`).attr('disabled', 'disabled');
            } else {
                $(`#from option`).removeAttr('disabled');
                $(`#from option[value=${ $(this).val() }]`).attr('disabled', 'disabled');
            }
        })
    </script>
@endsection
