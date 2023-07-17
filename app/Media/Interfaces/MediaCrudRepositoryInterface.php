<?php

namespace App\Media\Interfaces;
use App\FileUpload\DTO\File;


interface MediaCrudRepositoryInterface{
    public function create(File $fille);
}