<?php 

namespace App\FileUpload\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\Interfaces\UploadProductInterface;
use App\FileUpload\Interfaces\UploadProductMainInterface;
use App\FileUpload\DTO\File;

class UploadService implements UploadServiceInterface{

    public function __construct(
        private readonly UploadAvatarInterface $avatar,
        private readonly UploadBrandInterface $brand,
        private readonly UploadProductInterface $product,
        private readonly UploadProductMainInterface $product_main
    ) {}

    public function avatar($file,$collection_id=NULL): File{
        return $this->avatar->handle($file,$collection_id);
    }

    public function brand($file,$collection_id=NULL): File{
        return $this->brand->handle($file,$collection_id);
    }

    public function product($file,$collection_id=NULL): File{
        return $this->product->handle($file,$collection_id);
    }

    public function product_main($file,$collection_id=NULL): File{
        return $this->product_main->handle($file,$collection_id);
    }
}

