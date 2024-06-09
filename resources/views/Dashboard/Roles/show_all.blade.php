@extends('layouts.app')

@section('title')
    {{ __('roles_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_roles') }}">الادارات</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table table-hover fs-5">
                <thead>
                    <tr>
                        <th scope="col">اسم الادارة</th>
                        <th scope="col">عدد الاعضاء</th>
                        <th scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="">
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td><a href="{{route('edit_role',$role->id)}}"><i class="bi bi-pencil-square"></i></a></td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
