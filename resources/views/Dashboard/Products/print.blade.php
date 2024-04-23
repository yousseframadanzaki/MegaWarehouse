<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$variant->name}}</title>
    <style>
        .container{
            direction: rtl;
            margin: auto;
        }
        .attributes{
            display: flex;
            justify-content:center;
            font-size: 16px;
            font-weight: bold;
        }
        .attributes div{
            margin-left:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex;flex-direction:column;justify-content:center;align-items:center">
            {{-- {!! DNS1D::getBarcodeHTML($variant->sku, 'CODABAR') !!} --}}
            <div>
            {{$variant->sku}}
        </div>
        </div>
        <div style="font-weight: bold;text-align:center">
            <h4 style="margin: 0">{{$variant->product->name}} - <span>({{$variant->product->brand->name}})</span></h4 style="margin: 0">
        </div>
        <div class="attributes">
            {{$variant->name}}
        </div>
        <div style="text-align: center;margin-top:5px;">
            <span style="font-weight: bold">السعر</span>
            <span>{{$variant->price}}</span>
        </div>
    </div>
</body>
</html>
