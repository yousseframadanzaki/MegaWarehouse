@extends('layouts.app')

@section('title')
    {{ __('global.show_shipping_company_title') }}
@endsection

@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_shipping_companies') }}">شركات الشحن</a></li>
                <li><a class="link-dark"
                        href="{{ route('show_shipping_company', $shipping_company->id) }}">{{ $shipping_company->name }}</a>
                </li>
            </ul>
        </div>
        <div class="card p-3">
            <div class="row">
                <h3>بيانات الشركة</h3>
                <div class="col-md-3 fs-5">
                    <label class="fw-bold">اسم الشركة :</label>
                    <label>{{ $shipping_company->name }}</label>
                </div>
                <div class="col-md-3 fs-5">
                    <label class="fw-bold"> لينك الشركة :</label>
                    <label>{{ $shipping_company->url }}</label>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link @isset ($shipping_company_statuses)active @endisset" aria-current="page" href="{{route('show_shipping_company',$shipping_company->id)}}">حالات الشركة</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @isset ($shipping_company_areas)active @endisset" href="{{route('show_shipping_company_sectors',$shipping_company->id)}}">مناطق الشركة</a>
            </li>
        </ul>
        @isset ($shipping_company_statuses)
            @foreach ($shipping_company_statuses as $shipping_statuses)
                <div class="row mt-3 align-items-center">
                    <div class="col-md-4 fs-5">
                        <label class="fw-bold">{{$shipping_statuses['id']}} - {{ $shipping_statuses['name_ar'] }}</label>
                    </div>
                    <div class="col-md-4 fs-5">
                        <select class="status_select" style="width: 100%" data-shipping_status_id="{{ $shipping_statuses['id'] }}"
                            data-status_mapping_id="{{ $shipping_statuses['status_mapping_id'] }}">
                            <option value="">اختار الحالة</option>
                            @foreach ($statuses as $status)
                                <option @if ($status->id == $shipping_statuses['status_id']) selected @endif value="{{ $status->id }}">
                                    {{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        @endisset

        @isset ($shipping_company_areas)
            @foreach ($shipping_company_areas as $shipping_area)
                <div class="row mt-3 align-items-center">
                    <div class="col-md-4 fs-5">
                        <label class="fw-bold">{{$shipping_area['id']}} - {{ $shipping_area['name'] }} - {{ $shipping_area['gov'] }}</label>
                    </div>
                    <div class="col-md-4 fs-5">
                        <select class="area_select" style="width: 100%" data-shipping_area_id="{{ $shipping_area['id'] }}"
                            data-area_mapping_id="{{ $shipping_area['area_mapping_id'] }}">
                            <option value="">اختار المنطقة</option>
                            @foreach ($areas as $area)
                                <option @if ($area->id == $shipping_area['area_id']) selected @endif value="{{ $area->id }}">
                                    {{ $area->name }} - {{$area->city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        @endisset

    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.status_select').select2();
        $('.status_select').change(function() {
            var shipping_status_id = $(this).attr('data-shipping_status_id');
            var status_mapping_id = $(this).attr('data-status_mapping_id');
            var status_id = $(this).val();
            const shipping_company_id = '{!! $shipping_company->id !!}';
            const data = {
                shipping_status_id,
                status_mapping_id,
                status_id,
                shipping_company_id
            }

            add_mapping_status(data);
        });
        function add_mapping_status(data) {
            console.log(data);
            $.ajax({
                url: '/api/shipping_status/map',
                method: 'POST',
                data: data,
                dataType: 'json'
            }).then(response => {
                console.log(response);
                if (!response) {
                    alert('حدث خطاء أثناء التعديل');
                    return;
                }
            })
        }

        $('.area_select').select2();
        $('.area_select').change(function() {
            var shipping_area_id = $(this).attr('data-shipping_area_id');
            var area_mapping_id = $(this).attr('data-area_mapping_id');
            var area_id = $(this).val();
            const shipping_company_id = '{!! $shipping_company->id !!}';
            const data = {
                shipping_area_id,
                area_mapping_id,
                area_id,
                shipping_company_id
            }

            add_mapping_area(this,data);
        });
        function add_mapping_area(element,data) {
            $.ajax({
                url: '/api/shipping_area/map',
                method: 'POST',
                data: data,
                dataType: 'json',
                context:element
            }).then(response => {
                console.log(response);
                if (!response) {
                    alert('حدث خطاء أثناء التعديل');
                    return;
                }
                if(response.id){
                    console.log(response.id)
                    $(element).attr('data-area_mapping_id',response.id);
                }
            })
        }
    </script>
@endsection
