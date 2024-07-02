@extends('layouts.app')

@section('title')
    {{ __('add_supplier_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_suppliers') }}">الموردين</a></li>
                    <li><a class="link-dark" href="{{ route('add_supplier') }}">اضافة مورد جديد </a></li>
                </ul>
        </div>

        <form class="row  needs-validation" action="{{ route('store_supplier') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">إضافة مورد جديد</h1>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">عنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الايميل <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">كلمة السر <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ __($message) }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label">تأكيد كلمة السر </label>
                        <input type="password" class="form-control @error('password2') is-invalid @enderror" name="password2">
                        @error('password2')
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
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-warning my-3 rounded" style="cursor: pointer;" id="addImage">
                            أضف صورة للمورد
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <div class="input-images">
                        <input type="file" id="image-input" name="images" accept="image/*" style="display:none;">
                        <div id="image-container"></div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">إضافة مورد <i
                        class="bi bi-person-fill-add"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{url('/static/js/image-uploader.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#addImage').on('click', function() {
                $('#image-input').click();
            });

            $('#image-input').on('change', function(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Clear any existing images
                        $('#image-container').empty();

                        // Create new image element
                        const img = $('<img>').attr('src', e.target.result).css('max-width', '100%');

                        // Add the new image to the container
                        $('#image-container').append(img);
                    };

                    // Read the first file only
                    reader.readAsDataURL(files[0]);
                }
            });
        });
    </script>
@endsection
