<style>
    * {
        padding: 0px;
        margin: 0px;
    }

    table {
        border-collapse: collapse;
        border-collapse:separate;
        border-radius:25px;
        border-spacing: 0;
    }
    table td {
        vertical-align: top;
        padding: 3px;
        font-size: 14px;
        border: 1px solid;
    }

    table td span {
        font-weight: bolder;
    }

    tr:nth-child(odd) {
        background-color: #eeee;
    }

    td.no-border {
        border-left: 0;
        border-right: 0;
    }

    td.no-border:first-child {
        border-right: 1px solid #000;
        border-left: 0;
    }

    td.no-border:last-child {
        border-right: 0;
        border-left: 1px solid #000;
    }
    td{
        border: 0;
    }
    button {
        color: #FFFFFF;
        background-color: #4B8DF8;
        padding: 10px;
        border: 0;
    }
    div {
        line-height: 1.2;
    }
    .parent {
        padding: 5px;
        border: 2px solid #000;
        border-radius: 15px;
        width: 900px;
        height: 565px;
        margin: auto;
        margin-bottom: 40px;
        margin-top: 10px;
        direction: rtl;
        page-break-inside: avoid;
        overflow: hidden;
        position: relative;
    }
    .row {
        margin-top: 5px;
    }
    .header {
        display: flex;
    }
    .header .column .cod {
        padding: 1px;
        padding-left: 0;
        border: 2px solid #000;
        border-radius: 5px;
        margin-right: 10px;
        font-size: 18px;
        font-weight: bolder;
    }
    .header .column .cod span {
        padding: 10px;
        background-color: #EFEFEF;
        margin-right: 5px;
        border-radius: 5px 0px 0px 5px;
        border-right: 2px solid #000;
    }
    .header .column .service-type {
        padding: 1px;
        padding-left: 0;
        border: 2px solid #000;
        border-radius: 5px;
        margin-right: 10px;
        margin-top: 10px;
        font-size: 18px;
        font-weight: bolder;
        text-align: center;
    }
    .header .column {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* justify-content: center; */
        align-items: center;
    }
    .header .column:first-child {
        margin-left: auto;
        flex-direction: row;
        align-items: flex-start;
    }
    .header .column:last-child {
        margin-right: auto;
        align-items: center;
    }
    .header .barcode {
        margin: -10px -10px 0 0;
    }

    .body {
        display: flex;
        /* border-top: 2px solid #000; */
        margin-top: 5px;
        /* padding-top: 5px; */
        font-size: 14px;
    }

    .body .column {
        flex: 1 1 0px;
    }

    .body .column .row {
        padding: 5px;
        padding-right: 10px;
        /* margin-left: 10px; */
    }

    .body .column:first-child .row {

        margin-left: 10px;
    }

    .body .column .prime {
        background-color: #EFEFEF;
    }

    .body .column .double-items {
        display: flex;
    }

    .body .column .double-items>div {
        flex: 1 1 0px;
    }

    .body .column .triple-items {
        display: flex;
    }

    .body .column .triple-items>div {
        flex: 1 1 0px;
    }

    .body .double-line {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        width: 100%;
        height: 2.7em;
        overflow: hidden;
    }

    .body .triple-line {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        width: 100%;
        height: 3.5em;
        overflow: hidden;
    }

    .no-print {
        position: absolute;
        top: 0;
        left: 0;
    }

    .shipper {
        color: #000000;
        font-size: 18px;
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }

        .body .column .prime {
            background-color: #EFEFEF !important;
            print-color-adjust: exact;
        }

        @page {
            margin-top: 0.5in;
        }
    }

    @page {
        margin: 0.4in;
    }
    textarea.product_description{
        overflow: hidden;
        width: 100%;
        height: 210;
        box-sizing: border-box;
        resize:none;
        border: none;
        background: #fff;
        color: black;
    }
    .footer{
        position: absolute;
        display: flex;
        width: 100%;
        height: 40px;
        bottom: 0;
        align-items: center;
        text-align: center;
        background: #eee;
        padding: 10px;
        margin-right: -4px;
        border-radius: 0 0 15px 15px;
        margin-top: 5px;
        font-size: 12px;
        padding-top: 5px;
    }
</style>
<button class="no-print" onclick="window.print()"> طباعة </button>
    @foreach ($data as $order)
    <div class="parent" style="@if ($selected_option == '1' && $order->iteration % 1 == 0) page-break-after: always; @elseif ($selected_option == '2' ) @endif">
        <div class="header">
            <div class="column" style="margin-right: 20px;margin-top: 20px;">
                <div style="text-align: center;">
                    @isset($order->waybill)
                    {!! DNS1D::getBarcodeHTML($order->waybill, 'C128',2,40) !!}
                    @endisset
                    <h3>
                    <div style="font-weight: bold;">
                        @isset($order->waybill)
                        {{$order->waybill}}
                        @endisset
                    </div>
                    </h3>
                </div>
            </div>
            <div class="column">
                <div><img src="{{asset('/logo.png')}}" alt="Logo here" width="55" height="55"></div>
                <div style="margin-top: 10px">
                    <h3>{{ $order->companies->name }}</h3>
                </div>
                <div style="display: flex;justify-content:center;margin-top: 10px">
                    <div style="background:#eeee;border:2px solid #000;padding:7px;font-weight:600;border-radius:5px">الاجمالي شامل الشحن:  {{$order->total_after_sale}}</div>
                </div>
            </div>
            <div class="column">
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;margin-left: -85px;margin-top: 20px;">
                    {!! DNS1D::getBarcodeHTML($order->order_code, 'C128',1.5,30) !!}
                    <div style="font-weight: bold;">
                    {{$order->order_code}}
                    </div>
                    <h3> {{$order->city->name}} - {{$order->area->name}}</h3>
                    <p style="font-size: 14px;"> @date_format($order->created_at)</p>
                </div>
            </div>
        </div>
        <table style="width: 100%;margin-top:12px;">
            <tbody>
                <tr style="text-align: center;">
                    <td colspan="3" style="font-size: 16px;padding: 10px;"><span>العميل: </span> <b>{{$order->name}}<b> - @if($order->phone_1 && $order->phone_2)
                        <b>{{ $order->phone_1 }} - {{ $order->phone_2 }}</b>
                        @elseif($order->phone_1)
                            <b>{{ $order->phone_1 }}</b>
                        @elseif($order->phone_2)
                            <b>{{ $order->phone_2 }}</b>
                        @endif
                        <br>
                        <br>
                        <span>العنوان: {{$order->address}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
        @if (count($order->stocks) < 7)
        <h3 style="margin-top: 20px;margin-right: 235px;">المنتج
            <span style="margin-right: 200px;">العدد</span>
            <span style="margin-right: 30px;">السعر</span>
            <span style="margin-right: 40px;">الاجمالى</span>
        </h3>
        @foreach ($order->stocks as $item)
        <div class="body" style="align-items: center;width: 65%;margin-right: 235px;">
            <table style="width: 100%;margin-left:5px;">
                <tbody>
                    <tr style="height: 30px;direction: ltr;text-align: center;">
                        <center>
                        <td colspan="3" style="font-size: 14px;"><span>{{$item->variant->product->name??'منتج لمتغير موجود مسبقا'}}</span> @if(!empty($item->variant->name) && !empty($item->variant->product->name) && $item->variant->name != $item->variant->product->name) - {{$item->variant->name??'متغير موجود مسبقا'}} @endif</td>
                        </center>
                    </tr>
                </tbody>
            </table>
            <table style="width: 10%;margin-left:5px;">
                <tbody>
                    <tr colspan="2" style="height: 30px;text-align: center;">
                        <td style="font-size: 14px;"><span>{{abs($item->quantity)}}</b></td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 13%;margin-left:5px;">
                <tbody>
                    <tr colspan="2" style="height: 30px;text-align: center;">
                        <td style="font-size: 14px;"><span>{{abs($item->unit_price)}}</b></td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 16%;margin-left:5px;">
                <tbody>
                    <tr colspan="2" style="height: 30px;text-align: center;">
                        <td style="font-size: 14px;"><span>{{abs($item->unit_price * $item->quantity)}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
        @endif
        @if (count($order->stocks) >= 7)
            <h3 style="margin-top: 20px;margin-right:15px;">المنتجات
                <span style="margin-right: 145px;">العدد</span>
                <span style="margin-right: 38px;">السعر</span>
                <span style="margin-right: 40px;">الاجمالى</span>
                </h3>
            <div class="body" style="align-items: center;width: 100%;">
                <div style="display: flex; justify-content: space-between;width: 100%;">
                    <div style="width: 50%;">
                        @foreach ($order->stocks->take(7) as $item)
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="direction: rtl;font-size: 14px;text-align: center;"><p style="width: 250px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><span>{{$item->variant->product->name??'منتج لمتغير موجود مسبقا'}}</span> @if(!empty($item->variant->name) && !empty($item->variant->product->name) && $item->variant->name != $item->variant->product->name) - {{$item->variant->name??'متغير موجود مسبقا'}} @endif</p></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->quantity)}}</b></center></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->unit_price)}}</b></center></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->unit_price * $item->quantity)}}</b></center></td>
                                </tr>
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                    <div style="width: 50%;margin-left: 10px;">
                        @foreach ($order->stocks->slice(7) as $item)
                        <table style="margin-right:10px;width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="direction: rtl;font-size: 14px;text-align: center;"><p style="width: 250px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><span>{{$item->variant->product->name??'منتج لمتغير موجود مسبقا'}}</span> @if(!empty($item->variant->name) && !empty($item->variant->product->name) && $item->variant->name != $item->variant->product->name) - {{$item->variant->name??'متغير موجود مسبقا'}} @endif</p></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->quantity)}}</b></center></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->unit_price)}}</b></center></td>
                                    <td colspan="3" style="font-size: 14px;width: 60px;"><center>{{abs($item->unit_price * $item->quantity)}}</b></center></td>
                                </tr>
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div style="width: fit-content;font-size: 14px;font-weight: bold;margin: 10px 0px;background:#eeee;border:2px solid #000;padding:5px;border-radius:5px">سعر الشحن:  {{$order->delivery_cost}}</div>

        <div class="footer">
            <div>
                <h3>{{ json_decode($order->companies->data)->facebook }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                  </svg></h3>
                  <h3>{{ json_decode($order->companies->data)->instagram }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                  </svg></h3>
            </div>
            <div style="margin-top: 10px;margin-right: 160px;">
                <h3 style="width: 190px;">
                <span>{{ json_decode($order->companies->data)->phone }}</span>
                <h4>{{ json_decode($order->companies->data)->url }}</h4>
                </h3>
            </div>
            <div style="margin-right: 90px;">
                <h3 style="width: 250px;direction: rtl;">
                <span>{{ json_decode($order->companies->data)->address }}</span>
                </h3>
            </div>
        </div>
    </div>
    @endforeach
