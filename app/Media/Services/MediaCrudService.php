<?php 

namespace App\Media\Services;

use App\Media\Interfaces\MediaCrudRepositoryInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
use App\FileUpload\DTO\File;

class MediaCrudService implements MediaCrudServiceInterface{

    protected readonly MediaCrudRepositoryInterface $media_crud_repository;

    public function __construct(
        MediaCrudRepositoryInterface $media_crud_repository
    ) {
        $this->media_crud_repository = $media_crud_repository;
    }

    public function save(File $file){
        return $this->media_crud_repository->create($file);
    }
}

