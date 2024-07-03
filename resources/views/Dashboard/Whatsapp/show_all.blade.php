@extends('layouts.app')

@section('title')
    @lang('global.all_campaign')
@endsection
@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">@lang('global.dashboard')</a></li>
            <li><a class="link-dark" href="{{ route('whatsapp_campaigns') }}">@lang('global.all_campaign')</a></li>
        </ul>
    </div>
    <div id="message" style="display: none"></div>
    <table class="table table-hover">
        <thead>
            <th>@lang('global.campaign_id')</th>
            <th>@lang('global.campaign_name')</th>
            <th>@lang('global.campaign_user')</th>
            <th>@lang('global.campaign_time')</th>
            <th>@lang('global.campaign_orders')</th>
            <th>@lang('global.campaign_status')</th>
        </thead>
        <tbody>
            @foreach ($campaigns as $campaign)
            <tr>
                <td class="fw-bold">#{{ $campaign->id }}</td>
                <td>{{ $campaign->name }}</td>
                <td>{{ $campaign->user_name }}</td>
                <td>{{ \Carbon\Carbon::parse($campaign->schedule_date)->format('F j, Y h:i A') }}</td>
                <td>
                    @php
                        $order_codes = explode(',', $campaign->order_codes);
                        $order_ids = explode(',', $campaign->order_ids);
                    @endphp
                    @foreach ($order_codes as $key => $order_code)
                        <div style="background-color: #6e35ae; font-size: 14px;" class="badge p-2">
                            <a href="{{ route('show_order', $order_ids[$key]) }}" target="_blank" style="color: white;">{{ $order_code }}</a>
                        </div>
                    @endforeach
                </td>
                <td>
                    <select name="status" id="status_{{ $campaign->id }}" class="status">
                        <option value="pending" {{ $campaign->status == 'pending' ? 'selected' : '' }}>@lang('global.pending')</option>
                        <option value="not sent" {{ $campaign->status == 'not sent' ? 'selected' : '' }}>@lang('global.not sent')</option>
                        <option value="hold" {{ $campaign->status == 'hold' ? 'selected' : '' }}>@lang('global.hold')</option>
                        <option value="finished" {{ $campaign->status == 'finished' ? 'selected' : '' }}>@lang('global.finished')</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status').select2({
            width: '100%'
        });
    });
    $(document).on("change", ".status", function(e) {
        id = $(this).attr('id');
        campaign_id = id.split('_')[1];
        status = $('#status_'+campaign_id).val();
        _token = $('#token').val();
        if (confirm('هل أنت متأكد أنك تريد تغيير حالة الحملة؟')) {
            $.ajax({
                url: `/api/campaign/${campaign_id}/edit_status`,
                method: 'POST',
                data: {
                    status,
                    _token
                },
                dataType: 'text'
            }).then(data => {
                if (data == 'true') {
                    $('#status_'+campaign_id).val(status);
                    show_success('تم تغيير حالة الحملة بنجاح');
                }
            })
        } else {
            return 0;
        }
    });
    function show_success(message) {
        var template = `
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
        $('#message').append(template);
        $('#message').fadeIn();
    }
</script>
@endsection