@extends('layouts.app')

@section('title')
    {{ __('shipping_companies_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_shipping_companies') }}">شركات الشحن</a></li>
            </ul>
        </div>
        <table class="table table-hover">
            <thead>
                <th>اسم الشركة</th>
                <th>لينك الشركة</th>
                <th>حالة الشركة</th>
                <th>actions</th>
            </thead>
            <tbody>
                @foreach ($shipping_companies as $shipping_company)
                <tr>
                    <td><a @can('edit', $shipping_company) href="{{route('show_shipping_company',$shipping_company->id)}}" @endcan >{{$shipping_company->name}}</a></td>
                    <td>{{$shipping_company->url}}</td>
                    <td>
                        @if ($shipping_company->active)
                            <span class="badge rounded-pill bg-success">فعال</span>
                        @else
                            <span class="badge rounded-pill bg-danger">غير فعال</span>
                        @endif
                    </td>
                    <td>
                        
                        @can('edit', $shipping_company)
                            @if ($shipping_company->active)
                                <a href="{{route('deactivate_shipping_company',$shipping_company->id)}}"><i class="bi bi-dash-circle-fill link-danger" title="الغاء تفعيل الشركة"></i></a>
                            @else
                                <a href="{{route('activate_shipping_company',$shipping_company->id)}}"><i class="bi bi-plus-circle-fill link-success" title=" تفعيل الشركة"></i></a>
                            @endif
                            <a href="{{route('edit_shipping_company',$shipping_company->id)}}"><i class="bi bi-pencil-square"></i></a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection