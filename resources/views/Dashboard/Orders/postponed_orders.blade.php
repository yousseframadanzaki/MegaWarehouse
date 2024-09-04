@extends('layouts.app')

@section('title')
    {{-- {{ __('global.show_user_title') }} --}}
    الأوردرات المؤجلة
@endsection

@section('content')

    <style>
        .employee-card {
            /* background-color: #333; */
            color: #444;
            border-radius: 10px;
            padding: 20px;
        }
        .employee-card .btn-download {
            background-color: #00cc88;
            color: white;
            border: none;
        }
        .employee-card .btn-download:hover {
            background-color: #00aa77;
        }
        .employee-card .info-card {
            background-color: #6e35ae;
            border-radius: 10px;
            padding: 10px;
        }
    </style>

    <div class="container">
        <ul class="breadcrumb mt-4">
            <li><a href="{{ route('dashboard') }}">@lang('global.dashboard')</a></li>
            <li><a href="{{ route('all_users') }}">@lang('global.Orders')</a></li>
            <li><a class="link-dark" href="">الأوردرات المؤجلة</a></li>
        </ul>

        <div class="employee-card shadow border border-2 p-4 pb-2 my-4">
            <h5 class="info-card text-white mb-4 mx-auto" style="width: fit-content;">الأوردرات المؤجلة</h5>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>تاريخ التأجيل</th>
                            <th>عدد الأوردرات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td>{{ $row->postponed_date }}</td>
                                <td><a href="{{ route('all_orders') }}?order_ids={{ $row->order_ids }}">{{ $row->postponed_orders_count }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
