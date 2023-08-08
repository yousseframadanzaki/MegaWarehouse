@extends('layouts.app')

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">الاوردرات</a></li>
            </ul>
        </div>

        <div class="card shadow-sm p-3" >
            <form method="GET" action="{{route('all_products')}}" id="search">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control product_info @error('name') is-invalid @enderror"
                            name="name" value="{{Request::get('name')}}">
                        <div class="invalid-feedback name">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ماركة المنتج</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="brand_id" style="padding: 0.375rem 0.75rem;">
                            <option value="">اختار الماركة</option>
                            {{-- @foreach ($data['brands'] as $id => $name)
                                <option @if(Request::get('brand_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach --}}
                        </select>

                        <div class="invalid-feedback brand_id">

                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المورد </label>
                        <select class="form-select product_info" aria-label="Default select example" name="supplier_id">
                            <option value="">اختار المورد</option>
                            {{-- @foreach ($data['suppliers'] as $id => $name)
                                <option  @if(Request::get('supplier_id') == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                            @endforeach --}}
                        </select>

                        <div class="invalid-feedback supplier_id">

                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">تصنيف</label>
                        <select class="form-select product_info" aria-label="Default  select example" name="category_id"
                            id="category_id">
                            <option value="">اختار تصنيف </option>
                            {{-- @foreach ($data['categories'] as $cat)
                                <option @if(Request::get('category_id') == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->parents_names }}</option>
                            @endforeach --}}
                        </select>

                        <div class="invalid-feedback category_id">

                        </div>
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                </div>
            </form>
        </div>

        <table class="mt-3 table table-hover">
            <thead>
                <tr>
                    <th>رقم الاوردر</th>
                    <th>الادمن</th>
                    <th>الحالة</th>
                    <th>اسم العميل</th>
                    <th>رقم التليفون</th>
                    <th>العنوان</th>
                    <th>المنطقة</th>
                    <th>الاجمالى</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->admin->name}}</td>
                        <td>{{$order->status->name}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->phone_1}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->city->name}} - {{$order->area->name}}</td>
                        <td>{{$order->total}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection