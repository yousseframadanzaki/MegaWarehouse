@extends('layouts.app')
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_client_groups') }}">مجموعات العملاء</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col"> اسم مجموعات العملاء</th>
                        <th scope="col"> النسبة </th>
                        <th scope="col">عدد العملاء</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($client_groups as $client_group)
                        <tr class="">
                            <td>{{ $client_group->name }}</td>
                            <td>{{ $client_group->discount }}</td>
                            <td>{{ $client_group->clients_count?? '' }}</td>
                            <td>
                                @can('edit_client_group','App\Models\ClientGroup')
                                    <a  href="{{route('edit_client_group',$client_group->id)}}" class="link-primary"
                                        title="تعديل بيانات المجموعة">
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
                {!! $client_groups->links() !!}
            </div>
        </div>
    </div>
@endsection
