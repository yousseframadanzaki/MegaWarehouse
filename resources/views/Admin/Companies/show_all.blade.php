@extends('layouts.app')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">تسجيل دخول للشركة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('login_as_user')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="mb-3">
                                <label for="" class="form-label">المستخدم</label>
                                <select class="form-select form-select" name="user_id" id="user_id">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلاق</button>
                        <button type="submit" class="btn btn-primary">تسجيل دخول</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




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
                                    <a href="{{ route('deactivate_company', $company->id) }}" class="link-danger"
                                        title="الغاء تفعيل الشركة">
                                        <i class="bi bi-building-fill-lock"></i>
                                    </a>
                                @else
                                    <a href="{{ route('activate_company', $company->id) }}" class="link-success"
                                        title="تفعيل الشركة">
                                        <i class="bi bi-building-fill-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('edit_company', $company->id) }}"" class="link-primary "
                                    title="تعديل بيانات الشركة">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="link-dark" title="تسجيل الدخول" data-company_id="{{$company->id}}" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                                    <i class="bi bi-box-arrow-in-right"></i>
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
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {

            var loginModal = document.getElementById('loginModal');

            loginModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                var company_id = button.getAttribute('data-company_id');
                console.log('hi');
                $('#user_id').html('');
                $.ajax({
                    url: `/api/company/${company_id}/users`,
                    method: 'GET',
                    dataType: 'json'
                }).then(response => {
                    $('#user_id').html('<option value="">-- اختار المستخدم --</option>');
                    $.each(response, function(key, value) {
                        $("#user_id").append('<option value="' + value.id + '">' + value
                            .name + ' - ' + value.role.name + '</option>');
                    });
                    $('#user_id').select2({
                        dropdownParent: $('#loginModal')
                    });
                })
            });
        })
    </script>
@endsection
