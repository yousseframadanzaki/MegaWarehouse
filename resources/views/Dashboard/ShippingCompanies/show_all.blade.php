@extends('layouts.app')

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
                <th>actions</th>
            </thead>
            <tbody>
                @foreach ($shipping_companies as $shipping_company)
                <tr>
                    <td><a @can('edit', $shipping_company) href="{{route('show_shipping_company',$shipping_company->id)}}" @endcan >{{$shipping_company->name}}</a></td>
                    <td>{{$shipping_company->url}}</td>
                    <td>
                        @can('edit', $shipping_company)
                            <a href="{{route('edit_shipping_company',$shipping_company->id)}}"><i class="bi bi-pencil-square"></i></a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection