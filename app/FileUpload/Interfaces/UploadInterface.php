<?php

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;


interface UploadInterface{

    public function handle($fille,$collection_id=NULL): File;

}