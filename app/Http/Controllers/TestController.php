<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bundle;
use App\Models\Product;
use App\Models\Variant;

class TestController extends Controller
{
    public function test() {
        return Product::find(21)->bundle_variants;
    }
}
