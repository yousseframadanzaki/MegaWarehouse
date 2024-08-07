@extends('layouts.store_app')

@section('content')
    <style>
        label {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center my-4"> الأوردر الحالي</h3>
            </div>
        </div>
        <form action="" class="border px-4 pb-3 rounded">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center my-3">بيانات العميل</h5>
                    <hr>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_name">الاسم</label>
                        <input type="text" class="form-control" name="client[name]" id="client_name" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_phone">رقم التليفون</label>
                        <input type="text" class="form-control" name="client[phone]" id="client_phone" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="client_address">العنوان</label>
                        <input type="text" class="form-control" name="client[address]" id="client_address" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="city_id">المدينة</label>
                        <select class="form-control" name="client[city_id]" id="city_id" required></select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="form-group">
                        <label for="area_id">المنطقة</label>
                        <select class="form-control" name="client[area_id]" id="area_id" required></select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <h5 class="text-center my-3">محتويات الاوردر</h5>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="order_items_table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>سعر الوحدة</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        black-38
                                    </td>
                                    <td>
                                        50
                                    </td>
                                    <td>
                                        <input type="number" class="form-control border-secondary">
                                    </td>
                                    <td>100</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
@endsection
