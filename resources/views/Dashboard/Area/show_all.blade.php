@extends('layouts.app')
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_sectors') }}">مناطق الشحن</a></li>
        </ul>
    </div>
    <div id="message" style="display: none"></div>
    <table class="table table-hover">
        <thead>
            <th>اسم المنطقة</th>
            <th>سعر الشحن</th>
            <th>محافظة</th>
        </thead>
        <tbody>
            @foreach ($sectors as $sector)
            <tr>
                <td>{{ $sector->name }}</td>
                <td><input style="width: inherit;" class="form-control area_price"
                    data-id="{{ $sector->id }}" type="number" name="price"
                    value="{{ $sector->price }}"/></td>
                <td>{{ $sector->city->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    $(".area_price").change(function() {
        var price = $(this).val();
        var id = $(this).attr('data-id');
        if(confirm("هل تريد تغيير سعر الشحن؟")) {
            $.ajax({
                type: 'POST',
                url: `/api/sectors/${id}/edit`,
                dataType: "text",
                data: { price },
            }).then((response) => {
                $(".area_price").val(price);
            })
        } else {
            return false;
        }
    })
</script>
@endsection
