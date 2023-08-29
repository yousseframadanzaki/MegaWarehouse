@extends('layouts.app')
<style>
    .user-header-avatar{
        width: 60px;
        height: 60px;
        -webkit-border-radius: 60px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 50px;
        -moz-background-clip: padding;
        border-radius: 50px;
        background-clip: padding-box;
        margin: 7px 0 0 5px;
        float: left;
        background-size: cover;
        background-position: center center;
    }
</style>
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
                        <th scope="col">صورة</th>
                        <th scope="col">اسم العضو</th>
                        <th scope="col">ادارة</th>
                        <th scope="col">المخزن</th>
                        <th scope="col">تاريخ الاضافة</th>
                        <th scope="col">حالة العضو</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><div class="user-header-avatar" style="background-image: url('{{asset($user->avatar->path ?? '')}}')"></div></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>{{ $user->warehouse->name ?? "" }}</td>
                            <td>@date_format($user->created_at)</td>
                            <td>
                                @if ($user->active)
                                    <span class="badge rounded-pill bg-success">فعال</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">غير فعال</span>
                                @endif
                            </td>
                            <td>
                                
                                    
                                
                                @if ($user->active)
                                    @can('deactivate', 'App/Models/User')
                                        <a href="{{ route('deactivate_user', $user->id) }}" class="link-danger"
                                            title="الغاء تفعيل العضو">
                                            <i class="bi bi-person-fill-lock"></i>
                                        </a>
                                    @endcan
                                @else
                                    @can('activate', 'App/Models/User')
                                        <a href="{{ route('activate_user', $user->id) }}" class="link-success"
                                            title="تفعيل العضو">
                                            <i class="bi bi-person-fill-check"></i>
                                        </a>
                                    @endcan
                                @endif

                                @can('edit','App/Models/User')
                                    <a href="{{ route('edit_user', $user->id) }}" class="link-primary "
                                        title="تعديل بيانات العضو">
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
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection
