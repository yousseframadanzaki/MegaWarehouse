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
                     <option value="{{$name}}" @if(old('payment_category') == $name) selected @endif>{{$name}}</option>
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
                <option value="">اختار نوع العملية ...</option>
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
                <textarea class="form-control @error('note') is-invalid @enderror" name="note">{{old('note')}}</textarea>
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
                    <option value="">  من ...</option>
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
                    <option value="">  إلي ...</option>
                </select>
                @error('to')
                   <div class="invalid-feedback">
                         {{__($message)}}
                   </div>
                @enderror
             </div>

             <div class="col-12 mt-3">
                <div class="col-12">
                    <button type="button" class="btn btn-primary my-3 rounded" style="cursor: pointer;" id="addImage">
                        أضف صورة
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                <div class="input-images" style="cursor:pointer;"></div>
            </div>
         </div>

      <button class="btn btn-lg btn-primary mt-3 shadow-sm"> إضافة عملية مالية <i class="bi bi-plus"></i></button>
      </div>
   </form>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="{{url('/static/js/image-uploader.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            @if ($errors->any())
                payment_category();
            @endif
            $('select').select2();
            $('.input-images').imageUploader();
        })

        $('#addImage').on('click', function() {
            $('.image-uploader input').click();
        })

        $('#payment_category').on('change', payment_category);

        function payment_category() {
            category = $('#payment_category').val();
            role_type = 'default';

            $('#payment_type_id option:not([value=""])').remove();
            $('#from option:not([value=""])').remove();
            $('#to option:not([value=""])').remove();

            if (category != '') {
                if (category == 'Expense') {
                    role_type = 'manager';
                    $("#to").attr('disabled', 'disabled');
                    $("#to").parent().hide();
                } else {
                    $("#to").removeAttr('disabled');
                    $("#to").parent().show();
                }

                $.ajax({
                    url: `/api/category/${category}/payment_types`,
                    method: 'get',
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#payment_type_id').append(`<option value="${key}" ${ ('{{old("payment_type_id")}}' == key) ? 'selected' : '' }>${value}</option>`)
                        })
                    }
                })

                $.ajax({
                    url: `/api/users/company/role_type/${role_type}`,
                    method: 'get',
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#from').append(`<option value="${key}" ${ ('{{old("from")}}' == key) ? 'selected' : '' }>${value}</option>`)
                            $('#to').append(`<option value="${key}" ${ ('{{old("to")}}' == key) ? 'selected' : '' }>${value}</option>`)
                        })
                    }
                })
            }
        }

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
