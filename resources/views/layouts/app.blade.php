<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite(['resources/sass/app.scss', 'resources/css/app.css'])
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex flex-column col-2 flex-shrink-0 p-3 text-white bg-dark sticky-top" style="height:100vh">
                    <a href="/" class="d-flex  align-items-center mb-3 mb-md-0 text-white  text-decoration-none">
                        <span class="fs-4 ">Mega Warehouse</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto px-0">
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-white @if( request()->route()->getName() == "dashboard" ) active @endif" aria-current="page">
                                <i class="bi bi-house"></i>
                                الرئيسية
                            </a>
                        </li>
        
                        <li>
                            <a href="#" class="nav-link text-white @if( request()->route()->getName() === "add_company" ) active @endif" data-bs-toggle="collapse"
                                data-bs-target="#company-collapse" >
                                <i class="bi bi-building"></i>
                                الشركات
                            </a>
                            <div class="collapse" id="company-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="#" class="text-white"> <i class="bi bi-buildings"></i> كل
                                            الشركات </a></li>
                                    <li class="rounded "><a href="{{ route('add_company') }}" class="text-white"><i
                                                class="bi bi-building-add "></i> أضافة شركة</a></li>
                                </ul>
                            </div>
                        </li>
        
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                                class="rounded-circle me-2">
                            <strong>mdo</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
            </div>
            <div class="col col-10" style="" id="main">
                @include('partials.flash-messages')
                @yield('content')
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>

</html>
