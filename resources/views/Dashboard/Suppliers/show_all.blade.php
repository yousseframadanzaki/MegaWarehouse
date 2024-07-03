@extends('layouts.app')

@section('title')
    {{ __('global.suppliers_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_suppliers') }}">الموردين</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم المورد</th>
                        <th scope="col"> رقم التليفون </th>
                        <th scope="col"> العنوان</th>
                        <th scope="col"> الرصيد</th>
                        @can('edit','App\Models\Supplier')
                            <th scope="col">actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="">
                            <td><a href="{{ route('show_supplier',['supplier_id'=>$supplier->id])}}">{{ $supplier->name??'' }}</a></td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->total_invoices - $supplier->user->total_transactions }}</td>
                            @can('edit','App\Models\Supplier')
                                <td>
                                    <a  href="{{route('edit_supplier',$supplier->id)}}" class="link-primary"
                                        title="تعديل بيانات المورد">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $suppliers->links() !!}
            </div>
        </div>
    </div>
@endsection
