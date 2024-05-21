@extends('layouts.app')
@section('content')
    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a class="link-dark" href="{{ route('all_clients') }}">العملاء</a></li>
            </ul>
        </div>
        <div class="row card p-2 shadow-sm">
            <table class="table fs-5 table-hover">
                <thead>
                    <tr>
                        <th scope="col">اسم العميل</th>
                        <th scope="col"> مجموعة العملاء</th>
                        <th scope="col"> رقم التليفون </th>
                        <th scope="col"> رقم التليفون 2</th>
                        <th scope="col"> العنوان</th>
                        <th scope="col"> لينكات</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->client_group->name ?? '' }}</td>
                            <td>
                                {{ $client->phone_1 }}
                                <label> <i data-phone="{{ $client->phone_1 }}" data-client_id="{{ $client->id }}" data-bs-toggle="modal" data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;" class="bi bi-whatsapp"></i> </label>
                            </td>
                            <td>
                                {{ $client->phone_2 }}
                                <label> <i data-phone="{{ $client->phone_2 }}" data-client_id="{{ $client->id }}" data-bs-toggle="modal" data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;" class="bi bi-whatsapp"></i> </label>
                            </td>
                            <td>{{ $client->address }}</td>
                            <td>
                                @isset($client->links)
                                    @foreach ($client->links as $name => $value)
                                        <a class="bi bi-{{$name}}" href="{{$value}}"></a>
                                    @endforeach
                                @endisset
                            </td>
                            <td>
                                @can('edit_client','App\Models\Client')
                                    <a  href="{{route('edit_client',$client->id)}}" class="link-primary"
                                        title="تعديل بيانات العميل">
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
                {!! $clients->links() !!}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $('#whatsappModal').on('show.bs.modal',function (event) {
            var id = event.relatedTarget.getAttribute('data-client_id');
            var phone = event.relatedTarget.getAttribute('data-phone');

            $.ajax({
                url:`/api/client/${id}/get_templates`,
                method:'GET',
                dataType:'text'
            }).then(response =>{
                data = JSON.parse(response);
                if(data){
                    $("#whatsappModal .container-fluid").html("");
                    data.forEach(item => {
                        var template = `
                            <div class="row">
                                <div class="card template_card">
                                    <span>${item}</span>
                                    <a target="_blank" class="whatsapp_anchor" href="https://api.whatsapp.com/send?phone=2${phone}&text=${item}"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </div>
                        `
                        $("#whatsappModal .container-fluid").append(template);
                    });
                }
            })
        })
    </script>
@endsection