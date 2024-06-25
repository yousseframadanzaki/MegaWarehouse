@extends('layouts.app')

@section('title')
    {{ __('marketers_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_marketers') }}">المسوقين</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم المسوق</th>
                        <th scope="col"> رقم التليفون </th>
                        <th scope="col"> عدد الطلبات </th>
                        <th scope="col"> العمولات </th>
                        <th scope="col"> الرصيد </th>
                        <th scope="col"> اسم الصفحة</th>
                        <th scope="col"> لينكات</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marketers as $marketer)
                        <tr class="">
                            <td>{{ $marketer->name }}</td>
                            <td>{{ $marketer->phone_number }}</td>
                            <td>{{ $marketer->orders->count() }}</td>
                            <td>{{ $marketer->orders->sum('total_marketer_commission') }}</td>
                            <td></td>
                            <td>{{ $marketer->page_name }}</td>
                            <td>
                                @isset($marketer->links)
                                    @foreach (json_decode($marketer->links) as $name => $value)
                                        <a class="bi bi-{{$name}}" href="{{$value}}"></a>
                                    @endforeach
                                @endisset
                            </td>
                            <td>

                            <a  href="{{route('edit_marketer',$marketer->id)}}" class="link-primary"
                                title="تعديل بيانات المسوق">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $marketers->links() !!}
            </div>
        </div>
    </div>
@endsection
