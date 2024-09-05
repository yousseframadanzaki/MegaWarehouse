@extends('layouts.app')

@section('title')
    رصيد المسوق
@endsection

<style>
    label {
        font-weight: bold;
    }
</style>

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_marketers') }}">المسوقين</a></li>
                <li><a href="{{ route('show_marketer', $data['marketer']->id) }}">{{ $data['marketer']->name }}</a></li>
                <li><a class="link-dark" href="">رصيد المسوق </a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card p-5 shadow-sm">
                    <h3 class="text-center mb-4 bg-warning w-fit-content mx-auto p-3 rounded">المسوق: {{ $data['marketer']->name }}</h3>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="align-middle"> عدد الاوردرات تسليم <br> ( ناجح - جزئي - استبدال ) </th>
                                        <th class="align-middle">إجمالي العمولات</th>
                                        <th class="align-middle">العمولات المدفوعة</th>
                                        <th class="align-middle">العمولات المتبقية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data['marketer_orders']->count() }}</td>
                                        <td>{{ $data['marketer_commissions'] }}</td>
                                        <td>{{ $data['paid_commissions'] }}</td>
                                        <td>{{ $data['marketer_commissions'] - $data['paid_commissions'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-3 bg-warning w-fit-content p-3 rounded">العمليات المدفوعة للمسوق</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>من</th>
                                        <th>إلي</th>
                                        <th>القيمة</th>
                                        <th>نوع العملية</th>
                                        <th>تاريخ العملية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['marketer_transactions'] as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaction->from_user->name }}</td>
                                            <td>{{ $transaction->to_user->name }}</td>
                                            <td>{{ $transaction->value }}</td>
                                            <td>{{ $transaction->payment_type->name }}</td>
                                            <td>@date_format($transaction->created_at)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $data['marketer_transactions']->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
