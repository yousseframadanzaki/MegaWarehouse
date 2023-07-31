<?php

namespace App\Media\Interfaces;
use App\FileUpload\DTO\File;


interface MediaCrudServiceInterface{
    public function save(File $file);
    public function remove($id);
    public function UpdateMediaCollection($id,$collection);
    public function GetMediaByCollection($collection,$collection_id);
}