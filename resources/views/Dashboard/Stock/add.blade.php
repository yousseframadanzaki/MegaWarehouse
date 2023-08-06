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
            <form action="{{route('store_stock')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">المخزن<span class="text-danger">*</span></label>
                        <select class="form-select @error('warehouse_id') is-invalid @enderror product_info" aria-label="Default  select example" name="warehouse_id"
                            id="warehouse_id">
                            <option value="">اختار المخزن </option>
                            @foreach ($warehouses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_id')
                            <div class="invalid-feedback">
                                {{__($message)}}
                            </div>
                        @enderror
                        
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المنتج<span class="text-danger">*</span></label>
                        <select class="form-select @error('product_variants') is-invalid @enderror product_info" aria-label="Default  select example"
                            id="product_id">
                            <option value="">اختار المنتج </option>
                            @foreach ($products as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('product_variants')
                            <div class="invalid-feedback">
                                {{__($message)}}
                            </div>
                        @enderror
                        
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">نوع العملية<span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror product_info" aria-label="Default  select example" name="type"
                            id="type_id">
                            <option value="">اختار نوع العملية </option>
                                <option value="move">نقل لمخزن اخر</option>
                                <option value="buy">شراء</option>
                                {{-- <option value="sell">بيع</option>
                                <option value="returned_orders">مرتجعات الاوردرات</option>
                                <option value="returned_suppliers">مرتجعات للموردين</option> --}}
                        </select>
                        @error('type')
                        <div class="invalid-feedback ">
                            {{__($message)}}
                        </div>
                        @enderror
                    </div>
                    
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">صورة</label>
                            
                            <input type="file" name="image" id="" class="form-control">
                            <div class="invalid-feedback product_id">
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ملاحظة</label>
                            
                            <textarea rows="1" name="note" id="" class="form-control"></textarea>
                            <div class="invalid-feedback product_id">

                            </div>
                        </div>
                        <div class="col-md-4" >
                            <label class="form-label" id="warehouse_to_label" 
                            @if (!$errors->has('warehouse_to_id'))
                                style="display:none"
                            @endif>الى مخزن<span class="text-danger">*</span></label>
                            <select   name="warehouse_to_id"
                                id="warehouse_to_id" 
                                @if ($errors->has('warehouse_to_id'))
                                    
                                    class="form-select is-invalid product_info"
                                @else
                                    class="form-select"
                                    style="display:none"
                                @endif
                                >
                                <option value="">اختار المخزن </option>
                                @foreach ($warehouses as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('warehouse_to_id')
                                <div class="invalid-feedback">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="variants">

                        </div>
                    </div>
                        <button class="btn col-md-12 btn-lg btn-primary mt-3">أضافة العملية <i
                            class="bi bi-plus"></i></button>
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

$('#product_id').change(function () {
    var id = $(this).val();

    $("#variants").html("");

    $.ajax({
        type:'GET',
        url:`/api/product/${id}/variants`,
        dataType: "text",
    }).then((response)=>{
        data = JSON.parse(response);
        
        console.log(data);

        $.each(data, function (index,item) {
            var template = `
                <div class="row mt-3">
                    <input type="hidden" name="product_variants[${index}][id]" value="${item.id}"/>
                    <div class="col-md-4">
                        <input type="text" tabindex="-1" class="form-control " readonly value="${item.name}" />
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="product_variants[${index}][quantity]" class="form-control" placeholder="الكمية"/>
                    </div>
                </div>
            `;

            $("#variants").append(template);

        });
    })
})

$('#type_id').change(function () {
    var type = $(this).val();   
   if(type == 'move'){
        $("#warehouse_to_id").fadeIn()
        $("#warehouse_to_label").fadeIn()
        $("#warehouse_to_id").select2()
   }else{
        $("#warehouse_to_id").next(".select2-container").hide();
        $("#warehouse_to_id").val("");
        $("#warehouse_to_label").fadeOut()
   }
})

</script>

@endsection
