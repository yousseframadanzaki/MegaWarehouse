<?php

namespace App\FileUpload\Actions;

use Illuminate\Support\Facades\Storage;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\DTO\File;
class UploadBrand implements UploadBrandInterface
{
    public function handle($file,$company_id,$collection_id=NULL): File
    {
        $name = $file->hashName();
 
        $upload = Storage::put("public/brand/{$name}", $file);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "brand/$name/$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app/$upload",
                ),
            ),
            company_id :$company_id,
            collection: 'brand',
            collection_id: $collection_id,
        );
    }
}
