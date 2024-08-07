<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
    @vite(['resources/sass/app.scss', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="{{ url('/static/css/image-uploader.css') }}" />
    <link rel="icon" type="image/x-icon" href="/public/tab_icon.png">
    <style>
        body {
            background: white;
        }

        .sidebar {
            overflow-y: auto;
        }

        div#main {
            width: 100%;
        }

        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            font-size: 20px;
            border: none;
            outline: none;
            background-color: #6f35ae;
            color: white;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50%;
            transform: rotate(270deg);
            margin: 0px !important;
        }
    </style>
</head>

<body>
    <a href="#" class="d-inline-block" id="backToTop"><i class="bi bi-arrow-right"></i></a>

    <nav class="no-print navbar navbar-expand-lg navbar-dark navbar-bg">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('store.index') }}">Zioot Store</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-row">
                <li class="nav-item mx-2">
                    <a class="nav-link  " href="{{ route('store.add_order') }}" >
                        <i class="bi bi-cart-fill position-relative" style="font-size: 16px">
                            @if (Session::has('cart'))
                                @if (count(Session::get('cart')) > 0)
                                    <span style="font-size: 6px" class="badge bg-danger position-absolute translate-middle bottom-0 start-100">
                                        {{ count(Session::get('cart')) }}
                                    </span>
                                @endif
                            @endif
                        </i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="no-print sidebar-layout d-md-none">
            </div>
            <div class="col" id="main">
                @include('partials.flash-messages')
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    @vite(['resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $('.fixNumbers').on('input', function(e) {
            const arabicNumbers = [
                '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩',
            ];

            const numbers = [
                '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            ];

            const currentValue = this.value;
            let newValue = '';

            for (let i=0; i<currentValue.length; i++) {
                let index = arabicNumbers.indexOf(currentValue[i]);
                if (index !== -1)
                    newValue += numbers[index];
                else if (currentValue[i] != ' ')
                    newValue += currentValue[i];
            }

            this.value = newValue;
        });
    </script>
    @yield('script')
</body>

</html>
