<?php

namespace App\FileUpload\Actions;

use Illuminate\Support\Facades\Storage;
use App\FileUpload\Interfaces\UploadTransactionInterface;
use App\FileUpload\DTO\File;
class UploadTransaction implements UploadTransactionInterface
{
    public function handle($file,$company_id,$collection_id=NULL): File
    {
        $name = $file->hashName();

        $upload = Storage::put("public/transaction/{$name}", $file);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "storage/transaction/$name/$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app/$upload",
                ),
            ),
            company_id :$company_id,
            collection: 'transaction',
            collection_id: $collection_id,
        );
   }
}
