@extends('layouts.app')
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
            <th>السماح بتعديل الأوردر</th>
            <th>الحالات التابعة</th>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr>
                <td>{{ $status->name }}</td>
                <td style="width: 145px;">
                    <div class="form-check" style="margin-left: 50px;">
                        <input data-id="{{ $status->id }}" style="width: 20px;height: 20px;" class="form-check-input edit_btn" type="checkbox" name="edit_order" {{ $status->edit_order == 1 ? 'checked' : '' }}>
                    </div>
                </td>
                <td data-id="{{ $status->id }}" class="add_status">
                    @foreach ($status->related_statuses as $status)
                        <div style="background-color: #6e35ae;font-size: 14px;" class="badge p-2">
                            {{$status}}
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
        var token = $('#token').val();
        var id = $(this).attr('data-id');
        var edit_order = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            type: 'POST',
            url: `/api/statuses/${id}/settings`,
            dataType: "text",
            data: { token,edit_order },
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
                var newBadge = `<div style="background-color: #6e35ae; font-size: 14px;" class="badge p-2">${status}</div>`;
                td.append(newBadge);
            }
        });
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
        function show_succes(message) {
            var template = `
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            $('.message').append(template);
            $('.message').fadeIn();
        }
</script>
@endsection
