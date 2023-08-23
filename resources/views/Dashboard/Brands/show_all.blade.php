@extends('layouts.app')
<style>
    .brand-logo{
        width: 200px;
        height: 30px;
        background-clip: padding-box;
        margin: 7px 0 0 5px;
        float: right;
        background-size: cover;
        background-position: center center;
    }
</style>
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_brands') }}">الماركات</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5" style="vertical-align: middle;">
                <thead>
                    <tr>
                        <th scope="col" style="width: 1%">صورة</th>
                        <th scope="col">اسم الماركة</th>
                        @can('edit','App\Models\Brand')
                            <th scope="col">actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr class="">
                            {{-- <td><div class="brand-logo" style="background-image: url('{{asset($brand->logo->path ?? '')}}')"></div></td> --}}
                            <td><img src="{{asset($brand->logo->path ?? '')}}" style="object-fit: contain;height: 3vw;width:3vw" onerror="this.src = 'https://placehold.co/400?text=no+image'" /></td>
                            <td><a href="{{ route('all_products',['brand_id'=>$brand->id]) }}">{{ $brand->name }}</a></td>
                            @can('edit','App\Models\Brand')
                                <td>
                                    <a  href="{{route('edit_brand',$brand->id)}}" class="link-primary"
                                        title="تعديل بيانات الماركة">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <div dir="ltr" class="d-flex justify-content-center">
                {!! $brands->links() !!}
            </div>
        </div>
    </div>
@endsection
