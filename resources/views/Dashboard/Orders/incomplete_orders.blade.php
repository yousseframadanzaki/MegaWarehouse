@extends('layouts.app')

@section('title')
    {{-- {{ __('global.show_user_title') }} --}}
    نواقص الأوردرات
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
            <li><a class="link-dark" href="{{ route('incomplete_orders') }}">نواقص الأوردرات</a></li>
        </ul>

        <div class="employee-card shadow border border-2 p-4 pb-2 my-4">
            <h5 class="info-card text-white mb-4 mx-auto" style="width: fit-content;">نواقص الأوردرات</h5>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>المتغير</th>
                            <th>الرصيد الحالي</th>
                            <th>عدد قطع الاوردرات</th>
                            <th>عدد الاوردرات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $variant)
                            <tr>
                                <td>{{ $variant->product->name }}</td>
                                <td>{{ $variant->name }}</td>
                                <td>{{ $variant->quantity}}</td>
                                <td>{{ abs($variant->stock->sum('quantity')) }}</td>
                                <td><a href="{{ route('all_orders') }}?status_id=5">{{ $variant->stock->count() }}</a></td>
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
