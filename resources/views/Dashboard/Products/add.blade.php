@extends('layouts.app')

@section('content')
    <div class="p-3">
        {{-- <div class="row">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li><a href="{{ route('all_roles') }}">الادارات</a></li>
                <li>اضافة ادارة جديدة</li>
            </ul>
        </div> --}}
        <form class="row  needs-validation" novalidate action="{{ route('store_product') }}" method="POST">
            @csrf
            <div class="card p-5 shadow-sm">
                <h1 class="text-center">أضافة منتج جديدة</h1>
                <div class="row mb-3 mt-3">
                    <label>اسم المنتج</label>
                    <input type="text" name="product_info[name]" value=""/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>الحجم</label>
                    <input type="text" name="product_attributes[size][]" value="41"/>
                    <input type="text" name="product_attributes[size][]" value="42"/>
                    <input type="text" name="product_attributes[size][]" value="43"/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>لون</label>
                    <input type="text" name="product_attributes[color][]" value="red"/>
                    <input type="text" name="product_attributes[color][]" value="white"/>
                    <input type="text" name="product_attributes[color][]" value="black"/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>القماشة</label>
                    <input type="text" name="product_attributes[material][]" value="cotton"/>
                    <input type="text" name="product_attributes[material][]" value="silk"/>
                    <input type="text" name="product_attributes[material][]" value="polyster"/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>النوع الاول</label>
                    <input type="text" name="product_variants[1][sku]"      value="41/red/cotton"/>
                    <input type="text" name="product_variants[1][price]"      value="100"/>
                    <input type="text" name="product_variants[1][name]"      value="41/red/cotton"/>
                    <input type="text" name="product_variants[1][options][size]" value="41"/>
                    <input type="text" name="product_variants[1][options][color]" value="red"/>
                    <input type="text" name="product_variants[1][options][material]" value="cotton"/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>النوع الثانى</label>
                    <input type="text" name="product_variants[2][sku]"      value="41/red/silk"/>
                    <input type="text" name="product_variants[2][price]"      value="100"/>
                    <input type="text" name="product_variants[2][name]"      value="41/red/silk"/>
                    <input type="text" name="product_variants[2][options][size]"     value="41"/>
                    <input type="text" name="product_variants[2][options][color]"    value="red"/>
                    <input type="text" name="product_variants[2][options][material]" value="silk"/>
                </div>
                <div class="row mb-3 mt-3">
                    <label>النوع الثالت</label>
                    <input type="text" name="product_variants[3][sku]"      value="41/red/polyster"/>
                    <input type="text" name="product_variants[3][price]"      value="100"/>
                    <input type="text" name="product_variants[3][name]"      value="41/red/polyster"/>
                    <input type="text" name="product_variants[3][options][size]"      value="41"/>
                    <input type="text" name="product_variants[3][options][color]"     value="red"/>
                    <input type="text" name="product_variants[3][options][material]"  value="polyster"/>
                </div>
                <button class="btn btn-lg btn-primary mt-3 shadow-sm">أضافة منتج <i
                    class="bi bi-clipboard2-plus"></i></button>
            </div>
        </form>
    </div>
@endsection
