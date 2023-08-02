@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_warehouses') }}">المخازن</a></li>
                <li><a class="link-dark">اضافة عملية</a></li>
            </ul>
        </div>
        <div class="card shadow-sm p-3">
            <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">المخزن<span class="text-danger">*</span></label>
                        <select class="form-select product_info" aria-label="Default  select example" name="warehouse_id"
                            id="warehouse_id">
                            <option value="">اختار المخزن </option>
                            @foreach ($warehouses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback warehouse_id">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المنتج<span class="text-danger">*</span></label>
                        <select class="form-select product_info" aria-label="Default  select example" name="product_id"
                            id="product_id">
                            <option value="">اختار المنتج </option>
                            @foreach ($products as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback product_id">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">صورة<span class="text-danger">*</span></label>
                        
                        <input type="file" name="image" id="" class="form-control">
                        <div class="invalid-feedback product_id">

                        </div>
                    </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">ملاحظة<span class="text-danger">*</span></label>
                            
                            <textarea name="note" id="" class="form-control"></textarea>
                            <div class="invalid-feedback product_id">

                            </div>
                        </div>
                    </div>

                
            </form>
        </div>
    </div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$('select.product_info').select2({
    padding: 'resolve',
});
</script>

@endsection
