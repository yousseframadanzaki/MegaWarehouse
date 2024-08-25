<?php

namespace App\FileUpload\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use Illuminate\Support\Facades\Storage;
use App\FileUpload\DTO\File;

class UploadService implements UploadServiceInterface{
    private $category = [
        'avatar'          => ['folder' => 'avatar',       'collection' => 'avatars'],
        'brand'           => ['folder' => 'brand',        'collection' => 'brand'],
        'product'         => ['folder' => 'product',      'collection' => 'product'],
        'product_main'    => ['folder' => 'product/main', 'collection' => 'product.main_image'],
        'stock'           => ['folder' => 'stock',        'collection' => 'stock'],
        'transaction'     => ['folder' => 'transaction',  'collection' => 'transaction'],
        'status'          => ['folder' => 'status',       'collection' => 'order_status'],
        'variant'         => ['folder' => 'varient',      'collection' => 'varient'],
        'payment_reports' => ['folder' => 'payment_reports',      'collection' => 'payment_reports'],
    ];

    public function handle($file,$type,$company_id,$collection_id=NULL): File
    {
        $name = $file->hashName();

        $upload = Storage::put("public/{$this->category[$type]['folder']}/{$name}", $file);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "storage/{$this->category[$type]['folder']}/$name/$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app/$upload",
                ),
            ),
            company_id :$company_id,
            collection: $this->category[$type]['collection'],
            collection_id: $collection_id,
        );
    }
}

