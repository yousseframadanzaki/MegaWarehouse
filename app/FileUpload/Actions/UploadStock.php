<?php

namespace App\FileUpload\Actions;

use Illuminate\Support\Facades\Storage;
use App\FileUpload\Interfaces\UploadStockInterface;
use App\FileUpload\DTO\File;
class UploadStock implements UploadStockInterface
{
    public function handle($file,$company_id,$collection_id=NULL): File
    {
        $name = $file->hashName();
 
        $upload = Storage::put("public/stock/{$name}", $file);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "stock/$name/$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app/$upload",
                ),
            ),
            company_id :$company_id,
            collection: 'stock',
            collection_id: $collection_id,
        );
    }
}
