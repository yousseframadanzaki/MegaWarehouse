<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite(['resources/sass/app.scss', 'resources/css/app.css'])
    <style>
        .sidebar{
            overflow-y: auto;
        }
    </style>
</head>

<body>
    @vite(['resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <div class="container-fluid">
        <div class="row">

            <div class="d-flex sidebar flex-column flex-shrink-0 p-3 text-white bg-dark sticky-top" style="height:100vh;width:20%">
                    <a href="/" class="d-flex  align-items-center mb-3 mb-md-0 text-white  text-decoration-none">
                        <span class="fs-3 ">Mega Warehouse</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto px-0 fs-5">
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-white" aria-current="page">
                                <i class="bi bi-house"></i>
                                الرئيسية
                            </a>
                        </li>
                        @if (auth()->user()->is_admin)
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#company-collapse" >
                                <i class="bi bi-building"></i>
                                الشركات
                            </a>
                            <div class="collapse" id="company-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_companies') }}" class="text-white"> <i class="bi bi-buildings"></i> كل
                                            الشركات </a></li>
                                    <li class="rounded "><a href="{{ route('add_company') }}" class="text-white"><i
                                                class="bi bi-building-add "></i> أضافة شركة</a></li>
                                </ul>
                            </div>
                        </li>
                        @else
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#users-collapse" >
                                <i class="bi bi-person"></i>
                                الاعضاء
                            </a>
                            <div class="collapse" id="users-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_users') }}" class="text-white"> <i class="bi bi-people"></i> كل
                                            الاعضاء </a></li>
                                    <li class="rounded "><a href="{{ route('add_user') }}" class="text-white"><i
                                                class="bi bi-person-add "></i> أضافة عضو جديد</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#roles-collapse" >
                                <i class="bi bi-ui-checks"></i>
                                الادارات
                            </a>
                            <div class="collapse" id="roles-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_roles') }}" class="text-white"> <i class="bi bi-ui-checks"></i> كل
                                        الادارات </a></li>
                                    <li class="rounded "><a href="{{ route('add_role') }}" class="text-white"><i
                                                class="bi bi-clipboard2-plus"></i> أضافة ادارة جديدة</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#brands-collapse" >
                                <i class="bi bi-grid"></i>
                                الماركات
                            </a>
                            <div class="collapse" id="brands-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_brands') }}" class="text-white"> <i class="bi bi-grid"></i> كل الماركات </a></li>
                                    <li class="rounded "><a href="{{ route('add_brand') }}" class="text-white"><i
                                                class="bi bi-clipboard2-plus"></i> أضافة ماركة جديدة</a></li>
                                    
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#categories-collapse" >
                                <i class="bi bi-bookmark"></i>
                                التصنيفات
                            </a>
                            <div class="collapse" id="categories-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    
                                    <li class="rounded"><a href="{{ route('all_categories') }}" class="text-white"> <i class="bi bi-bookmarks"></i> كل التصنيفات </a></li>
                                    <li class="rounded "><a href="{{ route('add_category') }}" class="text-white"><i
                                                class="bi bi-bookmark-plus"></i> أضافة تصنيف جديد</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#clients-collapse" >
                                <i class="bi bi-person-hearts"></i>
                                العملاء
                            </a>
                            <div class="collapse" id="clients-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    
                                    <li class="rounded"><a href="{{ route('all_clients') }}" class="text-white"> <i class="bi bi-people"></i> كل العملاء </a></li>
                                    <li class="rounded "><a href="{{ route('add_client') }}" class="text-white"><i
                                                class="bi bi-person-plus"></i> أضافة عميل جديد</a></li>
                                    <li class="rounded"><a href="{{ route('all_client_groups') }}" class="text-white"> <i class="bi bi-people"></i> مجموعات العملاء </a></li>
                                    <li class="rounded "><a href="{{ route('add_client_group') }}" class="text-white"><i
                                                class="bi bi-person-plus"></i> أضافة مجموعة عملاء جديدة</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#suppliers-collapse" >
                                <i class="bi bi-person-lines-fill"></i>
                                الموردين
                            </a>
                            <div class="collapse" id="suppliers-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    
                                    <li class="rounded"><a href="{{ route('all_suppliers') }}" class="text-white"> <i class="bi bi-people"></i> كل الموردين </a></li>
                                    <li class="rounded "><a href="{{ route('add_supplier') }}" class="text-white"><i
                                                class="bi bi-person-plus"></i> أضافة مورد جديد</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#warehouse-collapse" >
                                <i class="bi bi-building"></i>
                                المخازن
                            </a>
                            <div class="collapse" id="warehouse-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    <li class="rounded"><a href="{{ route('all_warehouses') }}" class="text-white"> <i class="bi bi-buildings"></i> كل
                                            المخازن </a></li>
                                    <li class="rounded "><a href="{{ route('add_warehouse') }}" class="text-white"><i
                                                class="bi bi-building-add "></i> أضافة مخزن جديد</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                        
        
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                           
                            <strong>{{auth()->user()->name}}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </div>
            </div>

            <div class="col " style="width:80%" id="main">
                @include('partials.flash-messages')
                @yield('content')
            </div>
        </div>
    </div>



</body>

</html>
