@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin_dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_companies') }}">الشركات</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table table-hover fs-4">
                <thead>
                    <tr>
                        <th scope="col">اسم الشركة</th>
                        <th scope="col">نوع الشركة</th>
                        <th scope="col">اقصى عدد الاوردرات</th>
                        <th scope="col">اقصى عدد الاعضاء</th>
                        <th scope="col">حالة الشركة</th>
                        <th scope="col">actions</th>
                        {{-- <th scope="col">اسم owner</th>
                    <th scope="col">ايميل owner</th>
                    <th scope="col">رقم تليفون owner</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($companies as $company)
                        <tr>

                            <td>{{ $company->name }}</td>
                            <td>{{ $company->company_type }}</td>
                            <td>{{ $company->max_orders }}</td>
                            <td>{{ $company->max_users }}</td>
                            <td>
                                @if ($company->active)
                                    <span class="badge rounded-pill bg-success">فعالة</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">غير فعالة</span>
                                @endif
                            </td>
                            <td>
                                @if ($company->active)
                                    <a href="{{ route('company_deactivate', $company->id) }}" class="link-danger"
                                        title="الغاء تفعيل الشركة">
                                        <i class="bi bi-building-fill-lock"></i>
                                    </a>
                                @else
                                    <a href="{{ route('company_activate', $company->id) }}" class="link-success"
                                        title="تفعيل الشركة">
                                        <i class="bi bi-building-fill-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('company_edit', $company->id) }}"" class="link-primary "
                                    title="تعديل بيانات الشركة">
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
