<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('variants_print_title')</title>
    <style>
        .container{
            direction: rtl;
            margin: auto;
        }

        .barcode-card {
            width: 38mm;
            height: 12.5mm;
            margin: auto;
            margin-bottom: 0px;
            page-break-inside: avoid;
        }
        @media print {
            body {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    @php
        $flag = false;
    @endphp
    <div class="container">
        @foreach ($variants as $variant)
            <div class="parent" style="width: fit-content; margin: 2mm auto">
                @for ($i=0; $i<2; $i++)
                    <div class="barcode-card">
                        <div style="text-align:center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            <p style="margin: 0px; font-size: 9px;">{{$variant->product->name}} - <bdi><span>({{$variant->name}})</span></bdi></p>
                        </div>
                        <div style="width: fit-content; margin: 1px auto;">
                            {!! DNS1D::getBarcodeHTML($variant->sku, 'C128',1,20) !!}
                        </div>
                        <div style="text-align: center; margin: 0; font-size: 10px;">
                            {{$variant->sku}}
                        </div>
                    </div>
                @endfor
            </div>
        @endforeach
    </div>
</body>
</html>
