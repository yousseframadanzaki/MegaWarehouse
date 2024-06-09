@extends('layouts.app')

@section('title')
    {{ __('templates_title') }}
@endsection

@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_templates') }}">نصوص الرسائل</a></li>
        </ul>
    </div>
    <div class="row card p-2 shadow-sm">
        <table class="table fs-5 table-hover">
            <thead>
                <tr>
                    <th scope="col"> النص </th>
                    <th scope="col">نوع النص</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($templates as $template)
                <tr class="">
                    <td>{!! str_replace("\n", "<br>", $template->text) !!}</td>
                    <td>{{ $template->type }}</td>
                    <td>
                        @can('edit',$template)
                        <a href="{{route('edit_template',$template->id)}}" class="link-primary" title="تعديل بيانات المسوق">
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
            {{-- {!! $templates->links() !!} --}}
        </div>
    </div>
</div>
@endsection