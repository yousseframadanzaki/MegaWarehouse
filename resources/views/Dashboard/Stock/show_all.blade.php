@extends('layouts.app')

@section('content')
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <a>
                        <img src="" style="object-fit: cover;height:30vh;" />
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <p>
                        هل انت متأكد من الحذف؟
                    </p>
                    <div>
                        <a class="delete_btn btn btn-danger">نعم </a>
                        <a data-bs-dismiss="modal" class="delete_btn btn btn-secondary">لا</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_warehouses') }}">المخازن</a></li>
                <li><a class="link-dark" href="{{ route('all_stocks') }}">عمليات الخصم والاضافة</a></li>
            </ul>
        </div>

        <div class="card shadow-sm p-3">
            <form method="GET" action="{{ route('all_stocks') }}" id="search">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">المخزن</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="warehouse_id"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار المخزن</option>
                            @foreach ($data['warehouses'] as $id => $name)
                                <option @if (Request::get('warehouse_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback name">

                        </div>

                    </div>

                    <div class="col-md-4">
                        <label class="form-label">المنتج</label>
                        <select class="form-select product_info" aria-label="Default  select example" id="product_id"
                            name="product_id" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار المنتج</option>
                            @foreach ($data['products'] as $id => $name)
                                <option @if (Request::get('product_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback name">

                        </div>

                    </div>

                    <div class="col-md-4">
                        <label class="form-label">المتغيرات</label>
                        <select class="form-select" aria-label="Default  select example" name="variant_id" id="variant_id"
                            style="padding: 0.375rem 0.75rem;">

                        </select>

                        <div class="invalid-feedback name">

                        </div>

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">الادمن</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="admin_id"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار الادمن</option>
                            @foreach ($data['users'] as $id => $name)
                                <option @if (Request::get('admin_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback name">

                        </div>

                    </div>

                    <div class="col-md-4">
                        <label class="form-label">نوع العملية</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="type"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار نوع العملية</option>
                            <option value="move">{{ __('move') }}</option>
                            <option value="buy">{{ __('buy') }}</option>
                            <option value="sell">{{ __('sell') }}</option>
                        </select>

                        <div class="invalid-feedback name">

                        </div>

                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label">الموردين</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="supplier_id"
                            style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار المورد</option>
                            @foreach ($data['suppliers'] as $id => $name)
                                <option @if (Request::get('supplier_id') == $id) selected @endif value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">رقم الفاتورة</label>
                        <input class="form-control" name="invoice_id" id=""
                            value="{{ Request::get('invoice_id') }}">

                        <div class="invalid-feedback name">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ من</label>
                        <input class="form-control datetimeplugin" name="date_from" id=""
                            value="{{ Request::get('date_from') }}">

                        <div class="invalid-feedback name">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الى</label>
                        <input class="form-control datetimeplugin" name="date_to" id=""
                            value="{{ Request::get('date_to') }}">
                    </div>
                    
                </div>

                <div class="d-flex mt-3 justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        @if($data['filters'])
            <div class="card shadow-sm p-3 mt-2">
                <div class="d-flex justify-content-start row row-cols-5">
                    @foreach ($data['filters'] as $key => $value)
                        <div class="col sidebar-bg p-2 m-1" style="color: white">
                            {{__($key)}}: {{__($value)}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @canany(['add', 'delete'], 'App\\Models\Stock')
        <div class="card shadow-sm mt-3 p-3 d-flex flex-row">
            @can('add','App\\Models\Stock')
                <div class="fs-2"  title="أضافة عملية "><a href="{{route('add_stock')}}"><i class="text-primary bi bi-plus-square-fill"></i></a></div>
            @endcan
            @can('delete','App\\Models\Stock')
                <div class="fs-2" style="margin-right:20px" title="حذف عمليات "><a data-bs-toggle="modal" data-bs-target="#deleteModal" ><i class="text-danger bi bi-trash3-fill"></i></a></div>
            @endcan
        </div>
        @endcanany



        <div class="mt-3 shadow-sm">
            <table class="table table-hover border">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" class="form-check-input fs-3" id="check_all"/></th>
                        <th scope="col">نوع العملية</th>
                        <th scope="col"> المخزن </th>
                        <th scope="col"> الادمن</th>
                        <th scope="col">المنتج</th>
                        <th scope="col">المتغير</th>
                        <th scope="col">المورد</th>
                        <th scope="col">الكمية</th>
                        <th scope="col">الفاتورة</th>
                        <th scope="col">الاوردر</th>
                        <th scope="col">ملاحظة</th>
                        <th scope="col">صورة</th>
                        <th scope="col">تاريخ الاضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stock as $operation)
                        <tr>
                            <td><input type="checkbox" class="form-check-input fs-3 operation_id" value="{{$operation->id}}" name="operation_id"/></td>
                            <td>{{ __($operation->type) }}</td>
                            <td>{{ $operation->warehouse->name }}</td>
                            <td>{{ $operation->admin->name }}</td>
                            <td>{{ $operation->variant->product->name }}</td>
                            <td>{{ $operation->variant->name }}</td>
                            <td>{{ $operation->variant->product->supplier->name }}</td>
                            <td dir="ltr" class="text-end">
                                @if ($operation->quantity < 0)
                                    <span class="text-danger fw-bolder">{{ $operation->quantity }}</span>
                                @else
                                    <span class="text-success fw-bolder">{{ $operation->quantity }}</span>
                                @endif
                            </td>
                            <td><a >{{ $operation->invoice_id}}</a></td>
                            <td><a href="{{route('show_order',$operation->order_id ?? '')}}">{{ $operation->order->order_code ?? ''}}</a></td>
                            <td>{{ $operation->note }}</td>
                            <td>
                                @if ($operation->image)
                                    <a class="link-primary show_image" style="cursor: pointer" data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-image="{{ asset($operation->image->path ?? '') }}">
                                        <i class="bi bi-image"></i>
                                    </a>
                                @endif
                            </td>
                            <td dir="ltr">@date_format($operation->created_at)</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div dir="ltr" class="d-flex justify-content-center">
            {!! $stock->appends($_GET)->links() !!}
        </div>
    </div>

    <form id="delete_form" action="{{route('delete_stock')}}" method="POST">
        @csrf
    </form>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            
            $('select.product_info').select2({
                padding: 'resolve',
            });
            $(".air-datepicker-global-container").attr('dir', 'ltr');

            var params = new URLSearchParams(window.location.search);

            var product_id = params.get('product_id');
            var variant_id = params.get('variant_id');
            if(product_id && variant_id){
                $.ajax({
                type: 'GET',
                url: `/api/product/${product_id}/variants`,
                dataType: "text",
                }).then(async (response) => {
                    data = JSON.parse(response);
                    $('#variant_id').html('<option value="">-- اختار المتغير --</option>');
                    $.each(data, function(index, item) {
                        $("#variant_id").append('<option value="' + item.id + '">' + item.name +
                            '</option>');
                    });
                    $('#variant_id').fadeIn();
                    $('#variant_id').val(variant_id);
                    $('#variant_id').select2();
                })
            }
        })
        $('.show_image').click(function() {
            var image = $(this).attr('data-image');
            $("#imageModal .modal-body a").attr('href', image);
            $("#imageModal .modal-body a").attr('target', '_blank');
            $("#imageModal .modal-body a img").attr('src', image);
        })
        $("#product_id").change(function() {
            var id = this.value;
            $('#variant_id').html("");
            if (!id) {
                return;
            }
            $.ajax({
                type: 'GET',
                url: `/api/product/${id}/variants`,
                dataType: "text",
            }).then((response) => {
                data = JSON.parse(response);
                $('#variant_id').html('<option value="">-- اختار المتغير --</option>');
                $.each(data, function(index, item) {
                    $("#variant_id").append('<option value="' + item.id + '">' + item.name +
                        '</option>');
                });
                $('#variant_id').fadeIn();
                $('#variant_id').select2();
            })
        })
        $("#search").submit(function(e) {
            e.preventDefault();
            const query = {};
            $("#search input, #search select").each(function() {
                if ($(this).val()) {
                    query[$(this).attr('name')] = $(this).val();
                }
            })
            let params = new URLSearchParams(query);
            window.location.search = params.toString();
        })
        $("#check_all").click(function () {
            $(".operation_id").click();
        })
        $(".delete_btn").click(function (e) {
            ids = []
            $("input.operation_id:checked").each((index,element) => {
                ids.push($(element).val());
            });
            ids.forEach(element => {
                $('#delete_form').append("<input type='hidden' name='opertation_ids[]' value='"+element+"'' />");
            });
            $('#delete_form').submit();
        })
    </script>
@endsection
