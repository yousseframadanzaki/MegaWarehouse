<?php 

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;
interface UploadServiceInterface{
    public function avatar($file,$collection_id=NULL): File;
}