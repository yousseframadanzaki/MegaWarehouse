@extends('layouts.app')

@section('content')

    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_orders') }}">الاوردرات</a></li>
            </ul>
        </div>

        <table class="table table-hover">
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