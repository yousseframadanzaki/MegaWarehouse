<?php

namespace App\Media\Interfaces;
use App\FileUpload\DTO\File;


interface MediaCrudServiceInterface{
    public function save(File $fille);
}