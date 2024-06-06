<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductPackageRepositoryInterface;
use App\Models\Bundle;

class ProductPackageRepository implements ProductPackageRepositoryInterface{
    public function AddPackageItems($package_id, $data) {
        foreach ($data as $item) {
            $item['product_id'] = $package_id;
            Bundle::create($item);
        }
    }
}
