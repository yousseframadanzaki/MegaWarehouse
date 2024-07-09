@extends('layouts.app')

@section('title')
    {{ __('global.show_user_title') }}
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
            <li><a href="{{ route('all_users') }}">@lang('global.Users')</a></li>
            <li><a class="link-dark" href="{{ route('show_user', $user->id) }}">عرض عضو</a></li>
        </ul>

        <div class="employee-card shadow border border-2 p-4 pb-2">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <img src="{{ $user->avatar->path ?? 'https://via.placeholder.com/100' }}" style="height: 150px;" class="rounded-circle" alt="Profile Image">
                    <h3 class="mt-3">{{ $user->name }}</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="info-card text-white">
                        <span class="fw-bold">رقم الهاتف</span>
                        <hr class="my-2">
                        <p class="mb-0">{{ $user->phone_1 }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="info-card text-white">
                        <span class="fw-bold">الايميل</span>
                        <hr class="my-2">
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="info-card text-white">
                        <span class="fw-bold">الإدارة</span>
                        <hr class="my-2">
                        <p class="mb-0">{{ $user->role->name }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="info-card text-white">
                        <span class="fw-bold">الرصيد الحالي</span>
                        <hr class="my-2">
                        <p class="mb-0">{{ $balance }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="employee-card shadow border border-2 p-4 pb-2 my-4">
            <h5 class="info-card text-white mb-4 mx-auto" style="width: fit-content;">العمليات المالية</h5>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>رقم العملية</th>
                            <th>من</th>
                            <th>إلي</th>
                            <th>نوع العملية</th>
                            <th>تاريخ العملية</th>
                            <th>تمت بواسطة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->from_user->name }}</td>
                                <td>{{ $transaction->to_user->name}}</td>
                                <td>{{ $transaction->payment_type->name }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ $transaction->admin->name??'' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

            $('select.product_info').select2({
                padding: 'resolve',
            });
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
