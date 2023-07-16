@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_users') }}">الاعضاء</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table table-hover fs-5">
                <thead>
                    <tr>
                        <th scope="col">اسم العضو</th>
                        <th scope="col">الايميل</th>
                        <th scope="col">رقم تليفون</th>
                        <th scope="col">تاريخ الاضافة</th>
                        <th scope="col">حالة العضو</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="@if (!$user->active) table-danger @endif">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_1 }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if ($user->active)
                                    <span class="badge rounded-pill bg-success">فعال</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">غير فعال</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->active)
                                    <a href="{{ route('user_deactivate', $user->id) }}" class="link-danger"
                                        title="الغاء تفعيل العضو">
                                        <i class="bi bi-person-fill-lock"></i>
                                    </a>
                                @else
                                    <a href="{{ route('user_activate', $user->id) }}" class="link-success"
                                        title="تفعيل العضو">
                                        <i class="bi bi-person-fill-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('user_edit', $user->id) }}" class="link-primary "
                                    title="تعديل بيانات العضو">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
