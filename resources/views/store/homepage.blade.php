@extends('layouts.store_app')

@section('content')
    <style>
        .card-custom {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            transition: background-color 0.3s ease-in-out;
            z-index: 1;
        }
        .card-custom:hover .card-image {
            transform: scale(1.1);
        }
        .card-custom:hover .card-overlay {
            background-color: rgba(0, 0, 0, 0.6);
        }
        .category-name {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            z-index: 2;
            padding: 0 15px;
        }
    </style>

    <div class="container">
        <div class="row g-4">
            <div class="col-12">
                <h3 class="text-center mt-2"> الأصناف الأكثر شيوعا </h3>
                <p class="text-center my-2">كل صنف يحتوي علي العديد من المنتجات المتنوعة و الرائعة</p>
            </div>
            @foreach ($categories->take(8) as $category)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('store.show_category', $category->id) }}">
                        <div class="card-custom">
                            <img src="https://via.placeholder.com/250x250" alt="Category Image 1" class="card-image">
                            <div class="card-overlay"></div>
                            <div class="category-name">{{ $category->name }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
            @if ($categories->count() > 8)
                <div class="col-12">
                    <div class="text-center mt-2">
                        <a href="" class="btn btn-primary">عرض المزيد من التصنيفات</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
@endsection
