<?php 

namespace App\FileUpload\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\DTO\File;

class UploadService implements UploadServiceInterface{

    public function __construct(
        private readonly UploadAvatarInterface $avatar,
        private readonly UploadBrandInterface $brand,
    ) {}

    public function avatar($file,$collection_id=NULL): File{
        return $this->avatar->handle($file,$collection_id);
    }

    public function brand($file,$collection_id=NULL): File{
        return $this->brand->handle($file,$collection_id);
    }

}

