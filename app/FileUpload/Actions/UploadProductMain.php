<?php

namespace App\FileUpload\Actions;

use Illuminate\Support\Facades\Storage;
use App\FileUpload\Interfaces\UploadProductMainInterface;
use App\FileUpload\DTO\File;
class UploadProductMain implements UploadProductMainInterface
{
    public function handle($file,$collection_id=NULL): File
    {
        $name = $file->hashName();
 
        $upload = Storage::put("public\\product\\main\\{$name}", $file);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "product/main/$name/$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app\\$upload",
                ),
            ),
            collection: 'product.main_image',
            collection_id: $collection_id,
        );
    }
}
