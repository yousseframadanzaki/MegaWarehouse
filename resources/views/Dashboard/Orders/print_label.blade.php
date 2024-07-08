<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container{
            direction: rtl;
            margin-bottom: 15px;
        }
        .attributes{
            display: flex;
            justify-content:center;
            font-size: 13px;
        }
        .attributes div{
            margin-left:10px;
        }
    </style>
</head>
<body>
    @foreach ($data as $order)
    <div class="container" @if ($selected_option == '1' && $order->iteration % 1 == 0) page-break-after: always; @elseif ($selected_option == '2' ) @endif">
        <div style="display:flex;flex-direction:column;justify-content:center;align-items:center">
            {!! DNS1D::getBarcodeHTML($order->order_code, 'C128',1,20) !!}
            <div style="font-weight: bold;">
            {{$order->order_code}}
            </div>
        </div>
        <br>
        <div style="font-weight: bold;text-align:center">
            <h4 style="margin: 0">{{$order->city->name}} - <span>{{$order->area->name}}</span></h4 style="margin: 0">
        </div>
        {{-- <div class="attributes">
            @date_format($order->created_at)
        </div>
        <div style="text-align: center;margin-top:5px;">
            <span style="font-weight: bold">السعر</span>
            <span>{{$order->total_marketer_commission}} EGP</span>
        </div> --}}

    </div>
    @endforeach
</body>
</html>
