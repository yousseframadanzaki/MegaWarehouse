@extends('layouts.app')

@section('title')
    {{ __('global.move_stock_title') }}
@endsection

@section('content')
    <style>
        label {
            font-weight: bold;
        }

        .accordion-button::after {
            margin-left: 0px;
            margin-right: auto;
            background-color: white;
            border-radius: 50%;
            padding: 15px;
            background-position: center;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion {
            --bs-accordion-border-color: #9163c5;
        }

        .accordion-button,
        .accordion-button:not(.collapsed) {
            background-color: #9163c5;
            color: white;
            font-weight: bold
        }
    </style>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_warehouses') }}">المخازن</a></li>
                <li><a href="{{ route('all_stocks') }}">عمليات الخصم والاضافة</a></li>
                <li><a class="link-dark">نقل مخزون </a></li>
            </ul>
        </div>
        <div class="card shadow-sm p-3">
            <form action="{{route('store_stock')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input hidden value="move" name="type">
                    <div class="col-md-4 @error('warehouse_id') has-error @enderror">
                        <label class="form-label">المخزن<span class="text-danger">*</span></label>
                        <select class="form-select @error('warehouse_id') is-invalid @enderror product_info" aria-label="Default  select example" name="warehouse_id"
                            id="warehouse_id" required>
                            <option value="">اختار المخزن </option>
                            @foreach ($warehouses as $id => $name)
                                <option @if ($id == old('warehouse_id')) selected  @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_id')
                            <div class="invalid-feedback">
                                {{__($message)}}
                            </div>
                        @enderror

                    </div>
                    <div class="col-md-4 @error('product_variants') has-error @enderror">
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

                    <div class="col-md-4  @error('warehouse_to_id') has-error @enderror" >
                        <label class="form-label" id="warehouse_to_label">
                            الى مخزن<span class="text-danger">*</span></label>
                        <select   name="warehouse_to_id" id="warehouse_to_id" class="form-select is-invalid product_info" required>
                            <option value="">اختار المخزن </option>
                            @foreach ($warehouses as $id => $name)
                                <option @if ($id == old('warehouse_to_id')) selected  @endif value="{{ $id }}">{{ $name }}</option>
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
                        <div class="col-md-4">
                            <label class="form-label">صورة</label>

                            <input type="file" name="image" id="image" class="form-control">
                            <div class="invalid-feedback product_id">

                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ملاحظة</label>

                            <textarea rows="2" name="note" id="" class="form-control"></textarea>
                            <div class="invalid-feedback product_id">

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="preview" style="display: none">
                            <img id="preview_img" style="width: 200px;height:200px;object-fit:contain"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div id="variants">
                            <div class="accordion mt-3" id="accordionExample">
                            </div>
                        </div>
                    </div>
                        <button class="btn col-md-12 btn-lg btn-primary mt-3">نقل مخزون <i
                            class="bi bi-plus"></i></button>
            </form>
                        <button class="btn col-md-12 btn-lg btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#scan">
                            فحص <i class="bi bi-upc-scan"></i></button>
        </div>
    </div>
    <div class="modal fade" id="scan" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="display: block;text-align: center;">
                       <h5 class="modal-title"> فحص <i class="bi bi-upc-scan"></i></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <textarea name="scan_ids" id="scan_ids" cols="30" rows="5" style="width: 75%; height: 100%;"></textarea>
                            </div>
                            <div class="col-md-6">
                                <table class="table hover-table" style="width: 350px;margin-right: -65px;">
                                    <thead>
                                        <tr>
                                            <th>اسم المنتج</th>
                                            <th>sku</th>
                                            <th>الاسم</th>
                                            <th>الكمية</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scan-stock">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="save_stock btn btn-primary"> حفظ </button>
        </div>
    </div>
  </div>
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$('select.product_info').select2({
    padding: 'resolve',
});

let loop_index = 0;
$('#product_id').change(function () {
    var product_id = $(this).val();
    var product_name = $(this).find('option:selected').text();

    // $("#variants #accordionExample").html("");

    $.ajax({
        type:'GET',
        url:`/api/product/${product_id}/variants`,
        dataType: "text",
    }).then((response)=>{
        data = JSON.parse(response);
        let template = `
            <div class="accordion-item rounded mt-3">
                <h2 class="accordion-header" id="panels-heading${product_id}">
                    <button class="accordion-button rounded px-4 py-2 get_orders" type="button" data-bs-toggle="collapse" data-bs-target="#panels-collapse${product_id}" aria-expanded="true" aria-controls="panels-collapse${product_id}">
                        ${product_name}
                    </button>
                </h2>
                <div id="panels-collapse${product_id}" class="accordion-collapse collapse px-4 pt-4 pb-1" data-bs-parent="#accordionExample" aria-labelledby="panels-heading${product_id}">
        `;

        $.each(data, function (index,item) {
            template += `
                <div class="row mt-3">
                    <input type="hidden" name="product_variants[${loop_index}][id]" value="${item.id}"/>
                    <div class="col-md-4">
                        <input type="text" tabindex="-1" class="form-control " readonly value="${item.name}" />
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="product_variants[${loop_index++}][quantity]" class="form-control" placeholder="الكمية"/>
                    </div>
                </div>
            `;
        });

        template += `</div></div>`;
        $("#variants #accordionExample").append(template);
        $('#product_id :selected').prop('disabled', true);
    })
})

$("input#image").change(function (e) {
    const [file] = e.target.files;
    if(file){
        $("#preview_img").attr('src',URL.createObjectURL(file));
        $("#preview").fadeIn();
    }
})

$(document).ready(function() {
$(".save_stock").click(function (){
        rows = $(".variant_row")
        console.log(rows);
        $.each(rows, function (index,item) {
            variant = {};
            variant.id = $(item).attr("data-id");
            variant.product_name = $(item).find(".variant_row_pname").first().html()
            variant.name = $(item).find(".variant_row_name").first().html()
            variant.sku = $(item).find(".variant_row_sku").first().html()
            save_stock(variant);
        });
        $("#scan_ids").val('');
            $("#scan-stock").html('');
    });
    var scanned_ids = []
    $("#scan_ids").on('keypress',function(e) {
        var input = $("#scan_ids").val();
        input = input.replace(/\[/g, '').replace(/\]/g, '').replace(/\t/g, '');
        var ids = input.split('\n');
        var newId = ids.filter(function(id) {
            return !scanned_ids.includes(id);
        });
        let id = newId.toString();
        scanned_ids.push(...newId);

        if(e.which == 13) {
            $.ajax({
                url:`/api/stock/scan/`,
                method:'POST',
                data:{ id},
                }).then(data => {
                    if(data){
                        $.each(data, function (index,item) {
                        var template =
                        `<tr class="variant_row" data-id="${item.id}">
                            <td class="variant_row_pname">${item.product.name}</td>
                            <td class="variant_row_sku">${item.sku}</td>
                            <td class="variant_row_name">${item.name}</td>
                            <td>${item.quantity}</td>
                        </tr>`;
                        $("#scan-stock").append(template);

                    })
                }
                })
        }
    });
});
function save_stock(item){
        var index = $('#variants #accordionExample').children().length;

            var template = `
                <div class="row mt-3">
                    <input type="hidden" name="product_variants[${index}][id]" value="${item.id}"/>
                    <div class="col-md-4">
                        <input type="text" tabindex="-1" class="form-control " readonly value="${item.product_name}" />
                    </div>
                    <div class="col-md-4">
                        <input type="text" tabindex="-1" class="form-control " readonly value="${item.name}" />
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="product_variants[${index}][quantity]" class="form-control" placeholder="الكمية"/>
                    </div>
                </div>
            `;

            $("#variants #accordionExample").append(template);
}
</script>
@endsection
