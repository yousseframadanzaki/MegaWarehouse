@extends('layouts.app')

@section('title')
    {{ __('global.show_marketer_title') }}
@endsection

<style>
    label {
        font-weight: bold;
    }
</style>

@section('content')
    <div class="p-3">
        <div class="row">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    <li><a href="{{ route('all_marketers') }}">المسوقين</a></li>
                    <li><a class="link-dark" href="{{ route('show_marketer', ['marketer_id' => $marketer->id]) }}">عرض المسوق </a></li>
                </ul>
        </div>

        <div class="row">
            <div class="card p-5 shadow-sm">
                <h1 class="text-center mt-3">
                    <img src="{{ asset($marketer->user->avatar->path ?? '') }}" class="rounded" style="width: 100px; height: 100px;">
                    <p class="my-2 text-center"><a href="{{ route('show_marketer_balance', $marketer->id) }}" style="font-size: 14px; text-decoration: underline !important;">الذهاب لصفحة رصيد المسوق</a></p>
                </h1>
                <div class="row mb-3 mt-4">
                    <div class="col-md-4">
                        <label class="form-label">الاسم </label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رقم التليفون </label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->phone_number }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> اسم الصفحة</label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->page_name }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"> عدد الأوردرات </label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->orders_count }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> العمولات </label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->total_commission }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"> الرصيد </label>
                        <input type="text" class="form-control"
                            value="{{ $marketer->total_commission - $marketer->user->total_transactions }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label d-block">لينك فيسبوك <i class="bi bi-facebook"> </i></label>
                        <a href="{{ json_decode($marketer->links)->facebook }}" target="_blank">{{ json_decode($marketer->links)->facebook }}</a>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-block">لينك انستجرام <i class="bi bi-instagram"> </i></label>
                        <a href="{{ json_decode($marketer->links)->instagram }}" target="_blank">{{ json_decode($marketer->links)->instagram }}</a>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-block">لينك تيك توك <i class="bi bi-tiktok"> </i></label>
                        <a href="{{ json_decode($marketer->links)->tiktok }}" target="_blank">{{ json_decode($marketer->links)->tiktok }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
