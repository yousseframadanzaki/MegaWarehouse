@extends('layouts.app')

@section('title')
    {{ __('global.warehouses_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_warehouses') }}">المخازن</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم المخزن</th>
                        <th scope="col"> عدد الاعضاء </th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                        <tr class="">
                            <td><a href="{{route('all_stocks' , ['warehouse_id'=>$warehouse->id] )}}">{{ $warehouse->name }}</a></td>
                            <td>{{ $warehouse->users_count }}</td>
                            <td>
                                @can('edit','App\Models\Warehouse')
                                    <a  href="{{route('edit_warehouse',$warehouse->id)}}" class="link-primary"
                                        title="تعديل بيانات المخزن">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $warehouses->links() !!}
            </div>
        </div>
    </div>
@endsection
