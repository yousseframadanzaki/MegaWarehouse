<?php

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;
interface UploadServiceInterface{
    public function handle($file,$type,$company_id,$collection_id=NULL): File;
}
