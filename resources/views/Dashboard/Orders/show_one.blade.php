@extends('layouts.app')

@section('content')

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('change_order_status',$order->id)}}" method="POST">
                @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">الحالة</label>
                                <select id="status_id" name="status_id" style="width: 100%">
                                    <option value="">اختار الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option  value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="form-label">ملاحظة</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<style>
    tr.current_status{
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
</style>
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_orders') }}">الاوردرات</a></li>
            <li><a class="link-dark" href="{{ route('show_order',$order->id) }}">{{$order->order_code}} </a></li>
        </ul>

        <div class="card p-3 shadow-sm d-flex flex-row">
            <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"> تعديل الحالة <i class="bi bi-pencil-fill"></i></div>
        </div>

        <div class="card p-3 shadow-sm mt-3">
            <div class="row">
                <h3>بيانات العميل</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">اسم العميل :</label>
                    <label>{{$order->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم التليفون :</label>
                    <label>{{$order->phone_1}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> رقم تليفون اخر :</label>
                    <label>{{$order->phone_2}}</label>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">العنوان :</label>
                    <label>{{$order->address}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">المدينة :</label>
                    <label>{{$order->city->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">المنطقة :</label>
                    <label>{{$order->area->name}}</label>
                </div>
            </div>
            <div class="row mt-4">
                <h3>بيانات الاوردر</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم الاوردر :</label>
                    <label>{{$order->order_code}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">تاريخ الاضافة :</label>
                    <label>{{$order->created_at}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> الاجمالى :</label>
                    <label>{{$order->total}}</label>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> الادمن :</label>
                    <label>{{$order->admin->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> حالة :</label>
                    <label>{{$order->status->name}}</label>
                </div>
            </div>
            <div class="row mt-4">
                <h3>المنتجات</h3>
                <table class="table table-hover" id="variants_table">
                    <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>اسم المتغير</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الاجمالى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->pivot->quantity}}</td>
                                <td>{{$item->pivot->quantity * $item->price}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            </div>
            
        </div>
        
        <div class="row mt-3">
            <div class="card p-3 shadow-sm">
                <h3>الحالات</h3>
                <table class="table table-hover" id="variants_table">
                    <thead>
                        <tr>
                            <th>الادمن</th>
                            <th>الحالة</th>
                            <th>ملاحظة</th>
                            <th>صور</th>
                            <th>تاريخ الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->order_status as $status)
                            <tr class="@if($status->pivot->current) table-primary @endif">
                                <td>{{$status->pivot->admin->name}}</td>
                                <td>{{$status->name}}</td>
                                <td>{{$status->pivot->note}}</td>
                                <td>
                                    @if (count($status->pivot->images) > 0)
                                        <i class="bi bi-eye"></i>
                                    @endif
                                </td>
                                <td>{{$status->pivot->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#status_id').select2({
                dropdownParent: $('#statusModal')
            });
        })
    </script>
@endsection