@extends('layouts.app')

@section('title')
    {{ __('global.invoices_title') }}
@endsection

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
                <li><a href="{{ route('all_warehouses') }}">الحسابات</a></li>
                <li><a class="link-dark" href="{{ route('all_invoices') }}">الفواتير</a></li>
            </ul>
        </div>

        <div class="card shadow-sm p-3">
            <form method="GET" action="{{ route('all_invoices') }}" id="search">
                <div class="row mt-2">
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
                </div>
                <div class="row mt-2">


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

        <div class="mt-3 shadow-sm">
            <table class="table table-hover border">
                <thead>
                    <tr>
                        <th scope="col">رقم الفاتورة</th>
                        <th scope="col">المورد</th>
                        <th scope="col">قيمة الفاتورة</th>
                        <th scope="col">باقى لم يسدد</th>
                        <th scope="col">تاريخ الاضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                           <td><a href="{{route('show_invoice',$invoice->id)}}">{{$invoice->id}}</a></td>
                           <td>{{$invoice->supplier->name??''}}</td>
                           <td>{{$invoice->total_cost}}</td>
                           <td>{{$invoice->total_cost - $invoice->paid_amount}}</td>
                           <td >@date_format($invoice->created_at)</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div dir="ltr" class="d-flex justify-content-center">
            {!! $invoices->appends($_GET)->links() !!}
        </div>
    </div>

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

    </script>
@endsection
