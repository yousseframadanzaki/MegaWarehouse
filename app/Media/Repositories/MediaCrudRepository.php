<?php

namespace App\Media\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Models\Media;

use App\FileUpload\DTO\File;
use App\Media\Interfaces\MediaCrudRepositoryInterface;

class MediaCrudRepository implements MediaCrudRepositoryInterface
{
    public function create(File $file){
        return Media::create($file->toArray());
    }
}
