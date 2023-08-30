@extends('layouts.app')
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_transactions') }}">الحسابات</a></li>
            </ul>
        </div>

        

        <div class="row card p-2 shadow-sm">
            <table class="table" style="vertical-align: middle;">
                <thead>
                    <tr>
                        <th>رقم العملية</th>
                        <th>من</th>
                        <th>الى</th>
                        <th>القيمة</th>
                        <th>تكلفة الشحن</th>
                        <th>عمولة</th>
                        <th>ملاحظة</th>
                        <th>رقم الاوردر</th>
                        <th>رقم الفاتورة</th>
                        <th>نوع العملية</th>
                        <th>تاريخ الاضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->from_user->name}}</td>
                            <td>{{$transaction->to_user->name}}</td>
                            <td>{{$transaction->value}}</td>
                            <td>{{$transaction->delivery_cost}}</td>
                            <td>{{$transaction->commission}}</td>
                            <td>{{$transaction->note}}</td>
                            <td>{{$transaction->order->order_code ?? ''}}</td>
                            <td><a href="{{route('show_invoice',$transaction->invoice_id ?? '')}}">{{$transaction->invoice_id}}</td>
                            <td>{{$transaction->payment_type->name}}</td>
                            <td>@date_format($transaction->created_at)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {{-- {!! $transactions->links() !!} --}}
            </div>
        </div>
    </div>
@endsection
