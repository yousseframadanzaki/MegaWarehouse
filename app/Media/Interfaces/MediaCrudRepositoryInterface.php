<?php

namespace App\Media\Interfaces;
use App\FileUpload\DTO\File;


interface MediaCrudRepositoryInterface{
    public function create(File $file);
    public function remove($id);
    public function update_media_collection($id,$collection);
    public function get_media_by_collection($collection,$collection_id);
}