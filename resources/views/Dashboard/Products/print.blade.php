<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('global.variants_print_title')</title>
    <style>
        .container{
            direction: rtl;
            margin: auto;
        }
        .parent {
            width: 38mm;
            height: 25mm;
            margin: 0 auto;
            page-break-inside: avoid;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .barcode-card {
            width: 100%;
            height: 50%;
            box-sizing: border-box;
        }
        @media print {
            @page {
                size: 38mm 25mm;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }
            .barcode-card {
                margin: 0 auto;
            }
            .barcode-container {
                transform: scale(0.88);
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
            <div class="parent">
                @for ($i=0; $i<2; $i++)
                    <div class="barcode-card">
                        <div style="text-align:center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            <p style="margin: 0px; font-size: 9px;">{{$variant->product->name}} - <bdi><span>({{$variant->name}})</span></bdi></p>
                        </div>
                        <div class="barcode-container" style="width: fit-content; margin: 1px auto;">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
