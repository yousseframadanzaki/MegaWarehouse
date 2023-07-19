@extends('layouts.app')
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_clients') }}">العملاء</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم العميل</th>
                        <th scope="col"> مجموعة العملاء</th>
                        <th scope="col"> رقم التليفون </th>
                        <th scope="col"> رقم التليفون 2</th>
                        <th scope="col"> العنوان</th>
                        <th scope="col"> لينكات</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->client_group->name ?? '' }}</td>
                            <td>{{ $client->phone_1 }}</td>
                            <td>{{ $client->phone_2 }}</td>
                            <td>{{ $client->address }}</td>
                            <td>
                                @foreach (json_decode($client->links) as $name => $value)
                                    <a class="bi bi-{{$name}}" href="{{$value}}"></a>
                                @endforeach
                            </td>
                            <td>
                                <a  href="{{route('edit_client',$client->id)}}" class="link-primary"
                                    title="تعديل بيانات العميل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $clients->links() !!}
            </div>
        </div>
    </div>
@endsection
