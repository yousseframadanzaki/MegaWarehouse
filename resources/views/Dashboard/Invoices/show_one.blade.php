@extends('layouts.app')

@section('title')
    @lang('global.show_invoice_title')
@endsection

@section('content')
    <style>
        tr.current_status {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        @media print {
            body, .card, table, td, th {
                background-color: white !important;
            }

            .no-print {
                display: none !important;
            }

            .print-show {
                display: block !important;
            }

            #main .main-content {
                width: 95% !important;
                margin: auto !important;
            }

            .card {
                box-shadow: none !important;
                border-top-width: 3px !important;
                border-bottom-width: 3px !important;
                border-right: none !important;
                border-left: none !important;
                border-radius: 20px;
            }
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


    <!-- Modal -->
    <div class="modal fade"  id="payModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pay_invoice', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="mb-3">
                                <label for="" class="form-label"> من خزنة العضو </label>
                                <select class="form-select form-select @error('from') is-invalid @enderror" name="from"
                                    id="from_user_select">
                                    <option selected>اختار</option>
                                    @foreach ($users as $user)
                                        <option @if ($user->id == auth()->user()->id) selected @endif
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('from')
                                    <div class="invalid-feedback">
                                        {{ __($message) }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">القيمة</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror"
                                    name="value" id="value_input" placeholder="">
                                @error('value')
                                    <div class="invalid-feedback">
                                        {{ __($message) }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                   <label for="" class="form-label"> صورة</label>
                                   <input class="form-control @error('image') is-invalid @enderror" type="file"
                                   id="image_file" name="image">
                                   @error('image')
                                      <div class="invalid-feedback">
                                            {{__($message)}}
                                      </div>
                                   @enderror
                                 </div>
                             </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ملاحظة</label>
                                <textarea class="form-control" name="note" id="" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">تسديد</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <div class="p-3">
        <div class="row">
            <ul class="breadcrumb no-print">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_invoices') }}">الفواتير</a></li>
                @if (empty($invoice->total_cost) && empty($invoice->supplier_id))
                    <li><a class="link-dark"> إذن نقل {{ $invoice->id }} </a></li>
                @else
                    <li><a class="link-dark">فاتوره رقم {{ $invoice->id }} </a></li>
                @endif
            </ul>

            <div class="print-items p-0">
                <button class="btn btn-primary no-print" style="cursor: pointer;" onclick="window.print()">
                    طباعة
                </button>
                <div class="print-show d-none">
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-2">
                        <img src="{{asset('/logo.png')}}" alt="Logo here" width="55" height="55">
                        <h3 class="fw-bold">{{ $invoice->stocks[0]->company->name }}</h3>
                    </div>
                    <hr class="mb-5">

                    <h5 class="my-4">اسم المستلم : -------------------------</h5>
                    <h5 class="mb-5">التوقيع : -------------------------------</h5>
                </div>
            </div>

            @if (empty($invoice->total_cost) && empty($invoice->supplier_id))
                <h3 class="text-center mb-4"> إذن نقل {{ $invoice->id }}</h3>
                <div class="card border border-secondary p-3 shadow-sm mt-3">
                    <div class="row">
                        <h5 class="my-3">الأدمن: {{ $invoice->stocks[0]->admin->name }}</h5>
                        <h5 class="mb-3">التاريخ: {{ date_format($invoice->created_at, 'd-m-Y (h:i a)') }}</h5>
                        <h5 class="text-center mb-3">عمليات إذن النقل</h5>
                        <table class="table table-hover" id="variants_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">اسم المنتج</th>
                                    <th scope="col">اسم المتغير</th>
                                    <th scope="col">من مخزن</th>
                                    <th scope="col">إلي مخزن</th>
                                    <th scope="col">الكمية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    $invoice_stocks = $invoice->stocks;
                                    $from_warehouse = $invoice_stocks->where('quantity', '<', 0)->first()->warehouse->name;
                                    $to_warehouse = $invoice_stocks->where('quantity', '>', 0)->first()->warehouse->name;
                                @endphp

                                @foreach ($invoice_stocks->sortBy('variant_id') as $stock)
                                    @if ($loop->index % 2 == 0) 
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$stock->variant->product->name}}</td>
                                            <td>{{$stock->variant->name}}</td>
                                            <td>{{$from_warehouse}}</td>
                                            <td>{{$to_warehouse}}</td>
                                            <td>{{abs($stock->quantity)}}</td>
                                            @php $count ++ @endphp
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <h3 class="text-center mb-4 print-show d-none">فاتورة رقم {{ $invoice->id }}</h3>
                <div class="card border border-secondary p-3 shadow-sm mt-3">
                    <div class="row mt-3 print-show d-none">
                        <div class="col-12">
                            <h5 class="mb-3">الأدمن: {{ $invoice->stocks[0]->admin->name }}</h5>
                            <h5 class="mb-3">التاريخ: {{ date_format($invoice->created_at, 'd-m-Y (h:i a)') }}</h5>
                            <hr class="mb-3">
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="mb-3">بيانات المورد</h3>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold">اسم المورد :</label>
                            <label>{{ $invoice->supplier->name }}</label>
                        </div>
                        <div class="col-md-4 fs-5 no-print">
                            <label class="fw-bold">رقم التليفون :</label>
                            <label>{{ $invoice->supplier->phone }} @can('send_whatsapp', 'App\Models\Template')
                                    <i data-phone="{{ $invoice->supplier->phone }}" data-bs-toggle="modal"
                                        data-bs-target="#whatsappModal" style="color: #25D366;cursor: pointer;"
                                        class="bi bi-whatsapp"></i>
                                @endcan
                            </label>
                        </div>
                        <div class="col-md-4 fs-5 no-print">
                            <label class="fw-bold"> عنوان :</label>
                            <label>{{ $invoice->supplier->address }}</label>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h3 class="mb-3">بيانات الفاتورة</h3>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold">رقم الفاتورة :</label>
                            <label>{{ $invoice->id }}</label>
                        </div>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold">قيمة الفاتورة :</label>
                            <label>{{ $invoice->total_cost }}</label>
                        </div>
                        <div class="col-md-4 fs-5 no-print">
                            <label class="fw-bold"> باقى لم يسدد :</label>
                            <label>{{ $invoice->total_cost - $invoice->paid_amount }}</label>
                            @if($invoice->total_cost - $invoice->paid_amount != 0)
                            <button class="btn btn-primary btn-sm"
                                data-value="{{ $invoice->total_cost - $invoice->paid_amount }}" data-bs-toggle="modal"
                                data-bs-target="#payModal">تسديد</button>
                            @endif
                        </div>
                        <div class="col-md-4 fs-5 no-print">
                            <label class="fw-bold"> الادمن :</label>
                            <label>{{ $invoice->stocks[0]->admin->name }}</label>
                        </div>
                        <div class="col-md-4 fs-5">
                            <label class="fw-bold"> المخزن :</label>
                            <label>{{ $invoice->stocks[0]->warehouse->name }}</label>
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
                                @for ($i=0; $i<=3; $i++)
                                @foreach ($invoice->stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->variant->product->name }}</td>
                                        <td>{{ $stock->variant->name }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->unit_cost }}</td>
                                        <td>{{ $stock->unit_cost * $stock->quantity }}</td>
                                    </tr>
                                @endforeach
                                @endfor
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="card p-3 border border-secondary shadow-sm mt-3 no-print">
                    <div class="row">
                        <h3>الحسابات</h3>
                        <table class="table table-hover" id="variants_table">
                            <thead>
                                <tr>
                                    <th scope="col">من</th>
                                    <th scope="col">الى</th>
                                    <th scope="col">القيمة</th>
                                    <th scope="col">ملاحظة</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->from_user->name}}</td>
                                        <td>{{$transaction->to_user->name}}</td>
                                        <td>{{$transaction->value}}</td>
                                        <td>{{$transaction->note}}</td>
                                        <td>@date_format($transaction->created_at)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>


    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const pay_modal_errors = Object.entries({!! $errors !!});
            if(pay_modal_errors.length > 0){
                $('#payModal').modal('show');
            }
        })

        var whatsappModal = document.getElementById('whatsappModal');
        whatsappModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var phone = '2' + button.getAttribute('data-phone');
            $('.whatsapp_anchor').each(function(i, obj) {
                var href = new URL($(obj).attr('href'));
                href.searchParams.set('phone', phone);
                $(obj).attr('href', href.toString());
            });
        });

        var payModal = document.getElementById('payModal');
        payModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            let button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            let value = button.getAttribute('data-value');

            // Use above variables to manipulate the DOM
            var valueInput = document.getElementById('value_input');
            valueInput.value = value;
        });
    </script>
@endsection
