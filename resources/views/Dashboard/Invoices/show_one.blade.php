@extends('layouts.app')

@section('content')

<style>
    tr.current_status{
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    {{-- @foreach ($templates as $template)
                        <div class="row">
                            <div class="card template_card">
                                <span>{{$template}}</span>
                                <a target="_blank" class="whatsapp_anchor" href="https://api.whatsapp.com/send?text=@urlencode($template)"><i class="bi bi-whatsapp"></i></a>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>



<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
            <li><a href="{{ route('all_invoices') }}">الفواتير</a></li>
            <li><a class="link-dark">فاتوره رقم {{$invoice->id}} </a></li>
        </ul>

        <div class="card p-3 shadow-sm mt-3">
            <div class="row">
                <h3>بيانات المورد</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">اسم المورد :</label>
                    <label>{{$invoice->supplier->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم التليفون :</label>
                    <label>{{$invoice->supplier->phone}} @can('send_whatsapp','App\Models\Template') <i data-phone="{{$invoice->supplier->phone}}" data-bs-toggle="modal" data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;" class="bi bi-whatsapp"></i> @endcan</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> عنوان :</label>
                    <label>{{$invoice->supplier->address}}</label>
                </div>
            </div>
            <div class="row mt-4">
                <h3>بيانات الفاتورة</h3>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">رقم الفاتورة :</label>
                    <label>{{$invoice->id}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold">قيمة الفاتورة :</label>
                    <label>{{$invoice->total_cost}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> باقى لم يسدد :</label>
                    <label></label>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> الادمن :</label>
                    <label>{{$invoice->stocks[0]->admin->name}}</label>
                </div>
                <div class="col-md-4 fs-5">
                    <label class="fw-bold"> المخزن :</label>
                    <label>{{$invoice->stocks[0]->warehouse->name}}</label>
                </div>
            </div>
            <div class="row mt-4">
                <h3>المحتويات</h3>
                <table class="table table-hover" id="variants_table">
                    <thead>
                        <tr>
                            <th scope="col">المنتج</th>
                            <th scope="col">المتغير</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">تكلفة الوحدة</th>
                            <th scope="col">اجمالى التكلفة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->stocks as $stock)
                            <tr>
                                <td>{{$stock->variant->product->name}}</td>
                                <td>{{$stock->variant->name}}</td>
                                <td>{{$stock->quantity}}</td>
                                <td>{{$stock->variant->product->cost}}</td>
                                <td>{{$stock->variant->product->cost * $stock->quantity}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            </div> 
        </div>
        

    </div>
</div>

@endsection

@section('script')


    <script>
        $(document).ready(function() {
            
        })
        
        var whatsappModal = document.getElementById('whatsappModal');

        whatsappModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var phone = '2'+button.getAttribute('data-phone');
            $('.whatsapp_anchor').each(function(i, obj) {
                var href = new URL($(obj).attr('href'));
                href.searchParams.set('phone',phone);
                $(obj).attr('href',href.toString());
            });
        });

    </script>
@endsection