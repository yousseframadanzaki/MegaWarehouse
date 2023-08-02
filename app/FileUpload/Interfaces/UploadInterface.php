<?php

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;


interface UploadInterface{

    public function handle($file,$company_id,$collection_id=NULL): File;

}