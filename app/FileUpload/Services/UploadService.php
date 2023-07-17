<?php 

namespace App\FileUpload\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\DTO\File;

class UploadService implements UploadServiceInterface{

    public function __construct(
        private readonly UploadAvatarInterface $avatar,
    ) {}

    public function avatar($file,$collection_id=NULL): File{
        return $this->avatar->handle($file,$collection_id);
    }
}

