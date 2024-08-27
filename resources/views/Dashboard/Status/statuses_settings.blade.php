@extends('layouts.app')

@section('title')
    {{ __('global.settings_title') }}
@endsection

@section('content')
<div data-id="" class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="message" style="display: none"></div>
                            <div class="col-md-12">
                                <label class="form-label">الحالة</label>
                                <select id="status_id" name="status_id" style="width: 100%">
                                    <option value="">اختار الحالة</option>
                                    @foreach ($statuses as $status)
                                        <option  value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="" type="button" id="add_btn" class="btn btn-primary add_related_status">اضافة</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    </div>
        </div>
    </div>
</div>
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a class="link-dark" href="{{ route('all_statuses') }}">اعدادات الحالات</a></li>
        </ul>
    </div>
    <div id="message" style="display: none"></div>
    <table class="table table-hover">
        <thead>
            <th>الحالة</th>
            <th>لون الحالة</th>
            <th>صفحة جميع الأوردرات</th>
            <th>السماح بتعديل الأوردر</th>
            <th class="text-center"> قيد الشحن </th>
            <th>الحالات التابعة</th>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr>
                <td>{{ $status->name }}</td>
                <td class="text-center"><input type="color" style="cursor: pointer" value="{{ $status->color }}" data-id="{{ $status->id }}"></td>
                <td style="width: 145px;">
                    <div class="form-check" style="margin-left: 50px;">
                        <input data-id="{{ $status->id }}" style="width: 20px;height: 20px;" class="form-check-input show_all_orders_btn" type="checkbox" {{ $status->show_all_orders == 1 ? 'checked' : '' }}>
                    </div>
                </td>
                <td style="width: 145px;">
                    <div class="form-check" style="margin-left: 50px;">
                        <input data-id="{{ $status->id }}" style="width: 20px;height: 20px;" class="form-check-input edit_btn" type="checkbox" name="edit_order" {{ $status->edit_order == 1 ? 'checked' : '' }}>
                    </div>
                </td>
                <td style="width: 145px;">
                    <div class="form-check" style="margin-left: 50px;">
                        <input data-id="{{ $status->id }}" style="width: 20px;height: 20px;" class="form-check-input related_shipping_btn" type="checkbox" name="related_shipping" {{ $status->related_shipping == 1 ? 'checked' : '' }}>
                    </div>
                </td>
                <td data-id="{{ $status->id }}">
                    <div style="background-color: #6e35ae;font-size: 14px;" class="badge p-2">
                            <i data-id="{{ $status->id }}" class="bi bi-database-add add_status" style="cursor: pointer;"></i>
                    </div>
                    @foreach ($status->related_statuses as $related_status)
                        <div style="background-color: #6e35ae;font-size: 14px;" class="badge p-2 related_status_{{ $related_status['id'] }}">
                            {{ $related_status['name'] }}
                            <span class="icon-class">
                                <i data-status="{{ $related_status['id'] }}" data-id="{{ $status->id }}"  class="bi bi-trash status_remove" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row p-3">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#status_id').select2({
            dropdownParent: $('#statusModal')
        });
    });
    $(".add_status").click(function(){
        var id = $(this).data('id');
        $("#statusModal").attr('data-id', id);
        $("#add_btn").attr('data-id', id);
        $("#statusModal").modal('show');
    });
    $(".edit_btn").click(function(){
        var _token = $('#token').val();
        var id = $(this).attr('data-id');
        var edit_order = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: `/api/statuses/${id}/settings`,
            method: "POST",
            data: { _token, edit_order },
            dataType: "text"
        }).then((response) => {
            if (response) {
                show_success('تم تعديل الحالة بنجاح');
            }
        });
    });
    $(".related_shipping_btn").click(function(){
        var _token = $('#token').val();
        var id = $(this).attr('data-id');
        var related_shipping = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: `/api/statuses/${id}/settings`,
            type: 'POST',
            data: { _token,related_shipping },
            dataType: "text"
        }).then((response) => {
            if (response) {
                show_success('تم تعديل الحالة بنجاح');
            }
        });
    });
    $(".show_all_orders_btn").click(function(){
        var _token = $('#token').val();
        var id = $(this).attr('data-id');
        var show_all_orders = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: `/api/statuses/${id}/settings`,
            type: 'POST',
            data: { _token,show_all_orders },
            dataType: "text"
        }).then((response) => {
            if (response) {
                show_success('تم تعديل الحالة بنجاح');
            }
        });
    });
    $('input[type=color]').on('change', function() {
        _token = $('#token').val();
        color = $(this).val();
        id = $(this).attr('data-id');

        $.ajax({
            url: `/api/statuses/${id}/settings`,
            type: 'POST',
            data: { _token, color},
            dataType: "text"
        }).then((response) => {
            if (response) {
                show_success('تم تعديل الحالة بنجاح');
            }
        });
    });
    $(".add_related_status").click(function(e){
        id = $(this).attr('data-id');
        token = $('#token').val();
        related_status = $("#status_id").val();
        selectedOption = $('#status_id option:selected');
        status = selectedOption.text();
        $.ajax({
            type: 'POST',
            url: `/api/statuses/${id}/add_status`,
            dataType: "text",
            data: { token,related_status },
        }).then((response) => {
        data = JSON.parse(response)
            if (data == true){
                show_succes('تم اضافة الحالة نجاح');
                var td = $(`td[data-id='${id}']`);
                var newBadge = `<div style="background-color: #6e35ae; font-size: 14px;" class="badge p-2">${status}
                                    <span class="icon-class">
                                        <i data-status="${related_status}" data-id="${id}"  class="bi bi-trash status_remove" style="cursor: pointer;"></i>
                                    </span>
                                </div>`;
                td.append(newBadge);
            }
        });
    });
    $(".status_remove").click(function(e){
        related_status = $(this).attr('data-status');
        related_status_name = $(".related_status_" + related_status).text();
        status_id = $(this).attr('data-id');
        token = $('#token').val();
        $.ajax({
            type: 'POST',
            url: `/api/statuses/related_status/${related_status}/remove`,
            dataType: "text",
            data: { token,status_id },
        }).then((response) => {
            data = JSON.parse(response)
            if (data == true){
                show_success(`تم حذف ${related_status_name} من الحالات التابعة`);
                var td = $(`td[data-id='${status_id}']`);
                var badge = td.find(`div:has(i[data-status='${related_status}'])`);
                badge.remove();
            }
        });
    });
    function show_success(message){
        var template = `
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;
        $('#message').append(template);
        $('#message').fadeIn();
    };
    function show_succes(message){
        var template = `
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;
        $('.message').append(template);
        $('.message').fadeIn();
    };
</script>
@endsection
