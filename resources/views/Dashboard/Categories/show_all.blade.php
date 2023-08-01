@extends('layouts.app')
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_categories') }}">التصنيفات</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم التصنيف</th>
                        <th scope="col"> التصنيف الاب</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="">
                            <td><a  href="{{route('show_category',$category->id)}}" class="link-primary"
                                title="مشاهدة منتجات التصنيف">{{ $category->name }}</a></td>
                            <td><a href="{{route('show_category',$category->parent->id ?? '')}}">{{ $category->parent->name ?? '' }}</td>
                            <td>
                                <a  href="{{route('edit_category',$category->id)}}" class="link-primary"
                                    title="تعديل بيانات التصنيف">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $categories->links() !!}
            </div>
        </div>
    </div>
@endsection
