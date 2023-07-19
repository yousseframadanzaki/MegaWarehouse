@extends('layouts.app')
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
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="">
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>
                                <a  href="{{route('edit_supplier',$supplier->id)}}" class="link-primary"
                                    title="تعديل بيانات المورد">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
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
