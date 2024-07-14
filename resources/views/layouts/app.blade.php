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
        .sidebar {
            overflow-y: auto;
        }

        @media(max-width: 767.98px) {
            div.sidebar-layout {
                width: 100%;
                height:100vh;
                position: fixed;
                z-index: 1;
                top: 0px;
                right: 0px;
                visibility: hidden;
            }

            div.sidebar {
                width: 50%;
                position: fixed;
                right: 0;
                z-index: 1;
                visibility: hidden;
            }

            div#main {
                width: 100%;
            }
        }

        @media(min-width: 768px) {
            div.sidebar {
                width: 27%;
            }

            div#main {
                width: 70%;
            }
        }

        @media(min-width: 991px) {
            div.sidebar {
                width: 17%;
            }

            div#main {
                width: 80%;
            }
        }
    </style>
</head>
@php
    use App\Models\Link;

    $links = Link::with(['children' => function ($query) {
        $query->where('active', 1)->orderBy('sort');
    }])->where('parent_id', null)
      ->where('active', 1)
      ->orderBy('sort')
      ->get();
@endphp
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-bg">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">{{ auth()->user()->company->name }}</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-row">
                    <li class="nav-item mx-2">
                        <a class="nav-link  " href="{{route('add_order')}}" >
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
                    <li class="nav-item dropdown" style="font-size: 15px">
                        <a href="#" class="nav-link dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <strong>{{ auth()->user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="position: absolute;" aria-labelledby="dropdownUser1">

                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>
                </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-layout d-md-none">
            </div>
            <div class="d-flex sidebar sidebar-bg flex-column flex-shrink-0 p-3 text-white sticky-top"
                style="height:100vh;">
                <ul class="nav nav-pills flex-column mb-auto px-0 fs-5">
                    <li class="nav-item mb-2">
                        <a href="/" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house"></i>
                            الرئيسية
                        </a>
                    </li>
                    @if (auth()->user()->is_admin)
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#company-collapse">
                                <i class="bi bi-building"></i>
                                الشركات
                            </a>
                            <div class="collapse" id="company-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_companies') }}" class="text-white"> <i
                                                class="bi bi-buildings"></i> كل
                                            الشركات </a></li>
                                    <li class="rounded "><a href="{{ route('add_company') }}" class="text-white"><i
                                                class="bi bi-building-add "></i> أضافة شركة</a></li>
                                </ul>
                            </div>
                        </li>
                    @else
                        @foreach ($links as $link)
                            @php
                                $permissions = $link->permissions;
                                $resource = 'App\Models\\' . $link->resource;
                            @endphp
                            @canany($permissions, $resource)
                                <li>
                                    <a href="#" class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $link->id }}">
                                        <i class="{{ $link->icon }}"></i>
                                        {{ $link->name_ar }}
                                    </a>
                                    @if ($link->children->isNotEmpty())
                                        <div class="collapse" id="collapse-{{ $link->id }}">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                                @foreach ($link->children as $child)
                                                    @php
                                                        $childPermission = $child->permissions;
                                                        $childResource = 'App\Models\\' . $child->resource;
                                                    @endphp
                                                    @can($childPermission, $childResource)
                                                        <li class="rounded">
                                                            <a href="{{ route($child->route) }}" class="text-white">
                                                                <i class="{{ $child->icon }}"></i> {{ $child->name_ar }}
                                                            </a>
                                                        </li>
                                                    @endcan
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endcanany
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col " id="main">
                @include('partials.flash-messages')
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    @vite(['resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $('.navbar-toggler').on('click', function () {
            $('.sidebar-layout, .sidebar').css({'visibility': 'visible'})
        })

        $('.sidebar-layout').on('click', function (e) {
            $('.sidebar-layout, .sidebar').css({'visibility': 'hidden'})
        })

        $('table.table').addClass('table-bordered')
        // $('table.table').css('min-width', '700px');

        if (!$('table.table').parent().hasClass('table-responsive')) {
            $('table.table').wrap('<div class="table-responsive"></div>');
        }
    </script>
    @yield('script')
</body>

</html>
