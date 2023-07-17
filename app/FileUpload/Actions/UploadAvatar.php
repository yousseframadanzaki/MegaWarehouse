<?php

namespace App\FileUpload\Actions;

use Illuminate\Support\Facades\Storage;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\DTO\File;
class UploadAvatar implements UploadAvatarInterface
{
    public function handle($file,$collection_id=NULL): File
    {
        $name = $file->hashName();
 
        $upload = Storage::put("avatar\\{$name}", $file);

        // dd($name);

        return new File(
            name: "{$name}",
            file_name: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: "avatar\\$name",
            disk: 'local',
            hash: hash_file(
                'md5',
                storage_path(
                    path: "app\\$upload",
                ),
            ),
            collection: 'avatars',
            collection_id: $collection_id,
        );
    }
}
