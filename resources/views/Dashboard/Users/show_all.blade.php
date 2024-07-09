@extends('layouts.app')

@section('title')
    {{ __('global.users_title') }}
@endsection

<style>
    .user-header-avatar{
        width: 60px;
        height: 60px;
        -webkit-border-radius: 60px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 50px;
        -moz-background-clip: padding;
        border-radius: 50px;
        background-clip: padding-box;
        margin: 7px 0 0 5px;
        float: left;
        background-size: cover;
        background-position: center center;
    }

    label {
        font-weight: bold;
    }
</style>
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">@lang('global.dashboard')</a></li>
                <li><a class="link-dark" href="{{ route('all_users') }}">@lang('global.Users')</a></li>
            </ul>

            <div class="card shadow-sm p-3">
            <form method="GET" action="{{ route('all_users') }}" id="search">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">@lang('global.warehouse_id')</label>
                            <select class="form-select product_info" aria-label="Default  select example" name="warehouse_id"
                                style="padding: 0.375rem 0.75rem;">
                                <option value="">@lang('global.select_warehouse')</option>
                                @foreach ($data['warehouses'] as $id => $name)
                                    <option @if (Request::get('warehouse_id') == $id) selected @endif value="{{ $id }}">
                                        {{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback name">

                            </div>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">@lang('global.role_id')</label>
                            <select class="form-select product_info" aria-label="Default  select example" name="role_id"
                                style="padding: 0.375rem 0.75rem;">
                                <option value="">@lang('global.select_role')</option>
                                @foreach ($data['roles'] as $id => $name)
                                    <option @if (Request::get('role_id') == $id) selected @endif value="{{ $id }}">
                                        {{ $name }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback name">

                            </div>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">@lang('global.phone_1')</label>
                            <input class="form-control" name="phone" id=""
                                value="{{ Request::get('phone') }}">

                            <div class="invalid-feedback name">
                            </div>
                        </div>
                        <div class="d-flex mt-3 justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                @lang('global.button_search')
                            </button>
                        </div>
                    </div>
            </form>
        </div>

        </div>

        <div class="row card p-2 shadow-sm mt-3">
            <table class="table table-hover fs-5">
                <thead>
                    <tr>
                        <th scope="col">@lang('global.image')</th>
                        <th scope="col">@lang('global.user_name')</th>
                        <th scope="col">@lang('global.role_id')</th>
                        <th scope="col">@lang('global.warehouse_id')</th>
                        <th scope="col">@lang('global.created_at')</th>
                        <th scope="col">@lang('global.user_status')</th>
                        <th scope="col">@lang('global.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><div class="user-header-avatar" style="background-image: url('{{asset($user->avatar->path ?? '')}}')"></div></td>
                            <td><a href="{{ route('show_user', $user->id) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->role->name }}</td>
                            <td>{{ $user->warehouse->name ?? "" }}</td>
                            <td>@date_format($user->created_at)</td>
                            <td>
                                @if ($user->active)
                                    <span class="badge rounded-pill bg-success">@lang('global.active')</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">@lang('global.inactive')</span>
                                @endif
                            </td>
                            <td>



                                @if ($user->active)
                                    @can('deactivate', 'App/Models/User')
                                        <a href="{{ route('deactivate_user', $user->id) }}" class="link-danger"
                                            title="@lang('global.make_inactive')">
                                            <i class="bi bi-person-fill-lock"></i>
                                        </a>
                                    @endcan
                                @else
                                    @can('activate', 'App/Models/User')
                                        <a href="{{ route('activate_user', $user->id) }}" class="link-success"
                                            title="@lang('global.make_active')">
                                            <i class="bi bi-person-fill-check"></i>
                                        </a>
                                    @endcan
                                @endif

                                @can('view','App/Models/User')
                                    <a href="{{ route('edit_user', $user->id) }}" class="link-primary "
                                        title="@lang('global.button_update')">
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
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {

                $('select.product_info').select2({
                    padding: 'resolve',
                });
            })
            $("#search").submit(function(e) {
                e.preventDefault();
                const query = {};
                $("#search input, #search select").each(function() {
                    if ($(this).val()) {
                        query[$(this).attr('name')] = $(this).val();
                    }
                })
                let params = new URLSearchParams(query);
                window.location.search = params.toString();
            })
        </script>
@endsection
