<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite(['resources/sass/app.scss', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
        integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"
        integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    {{-- <nav class="navbar navbar-dark sidebar-bg justify-content-between flex-row">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">{{auth()->user()->company->name}}</a>
        </div>
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
    </nav> --}}

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar-layout d-md-none">
            </div>
            <div class="d-flex sidebar sidebar-bg flex-column flex-shrink-0 p-3 text-white sticky-top"
                style="height:100vh;">
                {{-- <a href="/" class="d-flex  align-items-center mb-3 mb-md-0 text-white  text-decoration-none">
                    <span class="fs-3 ">Mega Warehouse</span>
                </a>
                <hr> --}}
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
                        @canany(['view', 'add'], 'App\Models\User')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#users-collapse">
                                    <i class="bi bi-person"></i>
                                    الاعضاء
                                </a>
                                <div class="collapse" id="users-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\User')
                                            <li class="rounded"><a href="{{ route('all_users') }}" class="text-white"> <i
                                                        class="bi bi-people"></i> كل
                                                    الاعضاء </a></li>
                                        @endcan

                                        @can('add', 'App\Models\User')
                                            <li class="rounded "><a href="{{ route('add_user') }}" class="text-white"><i
                                                        class="bi bi-person-add "></i> أضافة عضو جديد</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Order')
                            <li>
                                <a href="#" class="nav-link text-white position-relative" data-bs-toggle="collapse"
                                    data-bs-target="#orders-collapse">
                                    <i class="bi bi-basket"></i>
                                    الاوردرات

                                </a>
                                <div class="collapse" id="orders-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Order')
                                            <li class="rounded"><a href="{{ route('all_orders') }}" class="text-white"> <i
                                                        class="bi bi-basket"></i> كل
                                                    الاوردرات </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Order')
                                            <li class="rounded "><a href="{{ route('add_order') }}" class="text-white"><i
                                                        class="bi bi-bag-plus"></i> أضافة اوردر جديد
                                                </a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany
                        @canany(['view', 'add'], 'App\Models\Product')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#products-collapse">
                                    <i class="bi bi-box-seam"></i>
                                    المنتجات
                                </a>
                                <div class="collapse" id="products-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Product')
                                            <li class="rounded"><a href="{{ route('all_products') }}" class="text-white"> <i
                                                        class="bi bi-boxes"></i> كل
                                                    المنتجات </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Product')
                                            <li class="rounded "><a href="{{ route('add_product') }}" class="text-white"><i
                                                        class="bi bi-plus-circle-fill"></i> أضافة منتج جديد</a></li>
                                        @endcan
                                        <li class="rounded "><a href="{{ route('add_package') }}" class="text-white"><i
                                            class="bi bi-plus"></i> أضافة باكيدج للمنتجات</a></li>
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view_invoice'], 'App\Models\Invoice')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#invoices-collapse">
                                    <i class="bi bi-cash"></i>
                                    الحسابات
                                </a>
                                <div class="collapse" id="invoices-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view_invoice', 'App\Models\Invoice')
                                            <li class="rounded"><a href="{{ route('all_invoices') }}" class="text-white">
                                                <i class="bi bi-cash-coin"></i> الفواتير </a></li>
                                        @endcan
                                        @can('view_transactions', 'App\Models\Transaction')
                                            <li class="rounded"><a href="{{ route('all_transactions') }}" class="text-white">
                                                <i class="bi bi-cash-coin"></i> عرض العمليات المالية </a></li>
                                        @endcan
                                        @can('add_transaction', 'App\Models\Transaction')
                                            <li class="rounded"><a href="{{ route('add_transaction') }}" class="text-white">
                                                <i class="bi bi-cash-coin"></i> إضافة عملية مالية </a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Role')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#roles-collapse">
                                    <i class="bi bi-ui-checks"></i>
                                    الادارات
                                </a>
                                <div class="collapse" id="roles-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Role')
                                            <li class="rounded"><a href="{{ route('all_roles') }}" class="text-white"> <i
                                                        class="bi bi-ui-checks"></i> كل
                                                    الادارات </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Role')
                                            <li class="rounded "><a href="{{ route('add_role') }}" class="text-white"><i
                                                        class="bi bi-clipboard2-plus"></i> أضافة ادارة جديدة</a></li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view_statuses'], 'App\Models\Status')
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#settings-collapse">
                                <i class="bi bi-gear"></i>
                                    الاعدادات
                            </a>
                            <div class="collapse" id="settings-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    @can(['view_statuses'], 'App\Models\Status')
                                        <li class="rounded"><a href="{{ route('all_statuses') }}" class="text-white"> <i
                                                    class="bi bi-gear"></i>
                                                اعدادات الحالات </a></li>
                                    @endcan
                                        <li class="rounded"><a href="{{ route('add_points') }}" class="text-white"> <i
                                            class="bi bi-plus"></i>
                                        اضافة نقاط (واتساب) </a></li>
                                </ul>
                            </div>
                        </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Brand')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#brands-collapse">
                                    <i class="bi bi-grid"></i>
                                    الماركات
                                </a>
                                <div class="collapse" id="brands-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Brand')
                                            <li class="rounded"><a href="{{ route('all_brands') }}" class="text-white"> <i
                                                        class="bi bi-grid"></i> كل الماركات </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Brand')
                                            <li class="rounded "><a href="{{ route('add_brand') }}" class="text-white"><i
                                                        class="bi bi-clipboard2-plus"></i> أضافة ماركة جديدة</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Category')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#categories-collapse">
                                    <i class="bi bi-bookmark"></i>
                                    التصنيفات
                                </a>
                                <div class="collapse" id="categories-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">

                                        @can('view', 'App\Models\Category')
                                            <li class="rounded"><a href="{{ route('all_categories') }}" class="text-white">
                                                    <i class="bi bi-bookmarks"></i> كل التصنيفات </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Category')
                                            <li class="rounded "><a href="{{ route('add_category') }}" class="text-white"><i
                                                        class="bi bi-bookmark-plus"></i> أضافة تصنيف جديد</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany
                        @canany(['view', 'add'], 'App\Models\Template')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#templates-collapse">
                                    <i class="bi bi-chat-square-text"></i>
                                    نصوص الرسائل
                                </a>
                                <div class="collapse" id="templates-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">

                                        @can('view', 'App\Models\Category')
                                            <li class="rounded"><a href="{{ route('all_templates') }}" class="text-white">
                                                    <i class="bi bi-chat-square-text"></i> كل نصوص الرسائل </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Category')
                                            <li class="rounded "><a href="{{ route('add_template') }}" class="text-white"><i
                                                        class="bi bi-body-text"></i> أضافة نص جديد</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view_clients', 'view_client_group', 'add_client', 'add_client_group'],
                            'App\models\client')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#clients-collapse">
                                    <i class="bi bi-person-hearts"></i>
                                    العملاء
                                </a>
                                <div class="collapse" id="clients-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view_clients', 'App\Models\Client')
                                            <li class="rounded"><a href="{{ route('all_clients') }}" class="text-white"> <i
                                                        class="bi bi-people"></i> كل العملاء </a></li>
                                        @endcan

                                        @can('add_client', 'App\Models\Client')
                                            <li class="rounded "><a href="{{ route('add_client') }}" class="text-white"><i
                                                        class="bi bi-person-plus"></i> أضافة عميل جديد</a></li>
                                        @endcan

                                        @can('view_client_groups', 'App\Models\ClientGroup')
                                            <li class="rounded"><a href="{{ route('all_client_groups') }}"
                                                    class="text-white"> <i class="bi bi-people"></i> مجموعات العملاء </a></li>
                                        @endcan

                                        @can('add_client_group', 'App\Models\ClientGroup')
                                            <li class="rounded "><a href="{{ route('add_client_group') }}"
                                                    class="text-white"><i class="bi bi-person-plus"></i> أضافة مجموعة عملاء
                                                    جديدة</a></li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Supplier')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#suppliers-collapse">
                                    <i class="bi bi-person-lines-fill"></i>
                                    الموردين
                                </a>
                                <div class="collapse" id="suppliers-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Supplier')
                                            <li class="rounded"><a href="{{ route('all_suppliers') }}" class="text-white">
                                                    <i class="bi bi-people"></i> كل الموردين </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Supplier')
                                            <li class="rounded "><a href="{{ route('add_supplier') }}" class="text-white"><i
                                                        class="bi bi-person-plus"></i> أضافة مورد جديد</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany(['view', 'add'], 'App\Models\Marketer')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#marketers-collapse">
                                    <i class="bi bi-person-workspace"></i>
                                    المسوقين
                                </a>
                                <div class="collapse" id="marketers-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Marketer')
                                            <li class="rounded"><a href="{{ route('all_marketers') }}" class="text-white">
                                                    <i class="bi bi-people"></i> كل المسوقين </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Marketer')
                                            <li class="rounded "><a href="{{ route('add_marketer') }}" class="text-white"><i
                                                        class="bi bi-person-plus"></i> أضافة مسوق جديد</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany
                        @canany(['view', 'add'], 'App\Models\ShippingCompany')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#shipping_companies-collapse">
                                    <i class="bi bi-truck"></i>
                                    شركات الشحن
                                </a>
                                <div class="collapse" id="shipping_companies-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\ShippingCompany')
                                            <li class="rounded"><a href="{{ route('all_shipping_companies') }}" class="text-white">
                                                    <i class="bi bi-truck"></i> كل شركات الشحن </a></li>
                                        @endcan

                                        @can('add', 'App\Models\ShippingCompany')
                                            <li class="rounded "><a href="{{ route('add_shipping_company') }}" class="text-white"><i
                                                        class="bi bi-plus"></i> أضافة شركة شحن</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany
                        @canany(['view', 'add'], 'App\Models\Area')
                        <li>
                            <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                data-bs-target="#area-collapse">
                                <i class="bi bi-map-fill"></i>
                                مناطق الشحن
                            </a>
                            <div class="collapse" id="area-collapse" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                    @can('add', 'App\Models\Area')
                                        <li class="rounded"><a href="{{ route('add_sector') }}" class="text-white">
                                                <i class="bi bi-map"></i> اضافة منطقة شحن </a></li>
                                    @endcan
                                    @can('view', 'App\Models\Area')
                                        <li class="rounded"><a href="{{ route('all_sectors') }}" class="text-white">
                                                <i class="bi bi-map"></i> كل مناطق الشحن </a></li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                        @endcanany
                        @canany(['view', 'add'], 'App\Models\Warehouse')
                            <li>
                                <a href="#" class="nav-link text-white" data-bs-toggle="collapse"
                                    data-bs-target="#warehouse-collapse">
                                    <i class="bi bi-building"></i>
                                    المخازن
                                </a>
                                <div class="collapse" id="warehouse-collapse" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small collapsible-sidenav">
                                        @can('view', 'App\Models\Warehouse')
                                            <li class="rounded"><a href="{{ route('all_warehouses') }}" class="text-white">
                                                    <i class="bi bi-buildings"></i> كل
                                                    المخازن </a></li>
                                        @endcan

                                        @can('add', 'App\Models\Warehouse')
                                            <li class="rounded "><a href="{{ route('add_warehouse') }}"
                                                    class="text-white"><i class="bi bi-building-add "></i> أضافة مخزن جديد</a>
                                            </li>
                                        @endcan

                                        @can('view', 'App\Models\Stock')
                                            <li class="rounded "><a href="{{ route('all_stocks') }}" class="text-white"><i
                                                        class="bi bi-stack "></i> عمليات الخصم والاضافة</a></li>
                                        @endcan
                                        @can('add', 'App\Models\Stock')
                                            <li class="rounded "><a href="{{ route('add_stock') }}" class="text-white"><i
                                                        class="bi bi-plus "></i> أضافة مخزون </a></li>
                                        @endcan
                                        @can('move', 'App\Models\Stock')
                                            <li class="rounded "><a href="{{ route('move_stock') }}" class="text-white"><i
                                                        class="bi bi-plus "></i> نقل مخزون </a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcanany

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"
        integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"
        integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
