<?php

namespace App\Products\Interfaces;

interface ProductPackageRepositoryInterface{
    public function AddPackageItems($package_id, array $data);
}
