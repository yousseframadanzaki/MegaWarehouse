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

    .footer {
        display: flex;
        /* border-top: 2px solid #000; */
        margin-top: 5px;
        font-size: 12px;
        padding-top: 5px;
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
</style>
<button class="no-print" onclick="window.print()"> طباعة </button>
    @foreach ($data as $order)
    <div class="parent" style="@if ($selected_option == '1' && $order->iteration % 1 == 0) page-break-after: always; @elseif ($selected_option == '2' ) @endif">
        <div class="header">
            <div class="column" style="align-content: flex-start;">
                <table style="width: 300px;height: 170px;margin-top:10px;">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size: 18px;padding: 5px;"><span>العميل: </span> <b>{{$order->name}}<b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-size: 18px;">
                                <div class="double-line"><span style="font-size: 15px;padding: 5px;">العنوان: {{$order->address}}</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-size: 18px;padding: 5px;"><span>رقم العميل:
                                    </span> @if($order->phone_1 && $order->phone_2)
                                        <b>{{ $order->phone_1 }} - {{ $order->phone_2 }}</b>
                                        @elseif($order->phone_1)
                                            <b>{{ $order->phone_1 }}</b>
                                        @elseif($order->phone_2)
                                            <b>{{ $order->phone_2 }}</b>
                                        @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="column">
                <div style="text-align: center;">
                    <svg id="{{$order->waybill}}"></svg>
                    <h2>
                    <div class="way-bill" style="font-weight: bold;display: none;">
                    @isset($order->waybill)
                     {{$order->waybill}}
                     @endisset
                    </div>
                    </h2>
                    <div style="display: flex;justify-content:center">
                        <div style="background:#eeee;border:2px solid #000;padding:7px;font-weight:600;border-radius:5px">{{$order->total}} جنيه</div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;margin-left: -85px;">
                    <svg id="{{$order->order_code}}"></svg>
                    <div class="code" style="font-weight: bold;display: none;">
                    {{$order->order_code}}
                    </div>
                    <p style="font-size: 14px;"> @date_format($order->created_at)</p>
                    <h3> {{$order->city->name}} - {{$order->area->name}}</h3>
                </div>
            </div>
        </div>
        <h2 style="margin-top: 60px;margin-right: 160px;">المنتجات</h2>
        @foreach ($order->stocks as $item)
        <div class="body" style="align-items: center;width: 65%;margin-right: 160px;">
            <table style="width: 50%;margin-left:5px;">
                <tbody>
                    <tr>
                        <td colspan="3" style="font-size: 18px;">{{$item->variant->product->name}}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 50%;margin-left:5px;">
                <tbody>
                    <tr colspan="2" style="height: 30px;">
                        <td style="font-size: 18px;"><span style="margin-right: 108px;">{{$item->variant->name}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach

        <!--<div class="footer" style="margin-bottom: 1px">
            تاريخ الاوردر : @date_format($order->created_at)
        </div>-->
    </div>
    @endforeach
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        $('.way-bill').each(function() {
            var waybill = $(this).text().trim();
            if(waybill != ""){
            JsBarcode("#" + waybill, waybill, {
                format: "CODE128",
                displayValue: true,
                fontSize: 18
            });
        }
        });
        $('.code').each(function() {
            var order_code = $(this).text().trim();
            if(order_code != ""){
                JsBarcode("#" + order_code, order_code, {
                    format: "CODE128",
                    displayValue: true
                });
            }
        });
    </script>
