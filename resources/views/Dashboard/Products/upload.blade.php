@extends('layouts.app')

@section('title')
    @lang('global.upload_products_csv')
@endsection

@section('content')
<div class="p-3">
    <div class="row">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">@lang('dashboard')</a></li>
            <li><a class="link-dark" href="{{ route('upload_products') }}">@lang('global.upload_products_csv')</a></li>
        </ul>
    </div>
    <div class="card shadow-sm p-3">
        <form action="{{ route('process_csv_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <label class="form-label">CSV File</label>
                    <input type="file" class="form-control @error('csv') is-invalid @enderror"
                        name="csv" value="">
                    <div class="invalid-feedback">
                        @error('csv')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 my-4">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            @lang('global.upload')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @isset($csvData)
    <form action="{{ route('add_csv_products') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card shadow-sm mt-3 p-3">
                <div class="table-responsive">
                    <table id="productsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 65px;">Select</th>
                                @foreach($csvData[0] as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($csvData, 1) as $row)
                                <tr>
                                    <td style="width: 65px;">
                                        <input class="form-check-input product-checkbox" type="checkbox" name="selectedProducts[]" value="{{ $loop->index }}">
                                    </td>
                                    @foreach($row as $cellIndex => $cell)
                                    <td>
                                        <input class="form-control" type="text" name="items[{{ $loop->parent->index }}][product_info][{{ $csvData[0][$cellIndex] }}]" value="{{ $cell }}">
                                    </td>
                                    @endforeach
                                    <td class="category-cell"> 
                                        <input class="form-control" type="text" name="items[{{ $loop->index }}][product_info][category_id]" value="">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">@lang('category')</label>
                    <select id="categorySelect" name="category_id" class="form-select">
                        <option value="">اختار تصنيف </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" id="updateProductsBtn" class="btn btn-primary">
                        @lang('global.add_products')
                    </button>
                </div>
            </div>
        </form>
    @endisset
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $('#categorySelect').select2();
    $(document).on("change", "#categorySelect", function(e) {
        var selectedProducts = [];
        $('input[name="selectedProducts[]"]:checked').each(function() {
            selectedProducts.push($(this).val());
        });

        var category_id = $(this).val();
        selectedProducts.forEach(function(index) {
            var $row = $('#productsTable').find('tbody tr').eq(index);
            $row.find('input[name="items[' + index + '][product_info][category_id]"]').val(category_id);
        });

        $('input[name="selectedProducts[]"]:checked').prop('checked', false);
    });
</script>
@endsection
