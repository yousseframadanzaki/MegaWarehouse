<?php

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;


interface UploadInterface{

    public function handle($file,$collection_id=NULL): File;

}