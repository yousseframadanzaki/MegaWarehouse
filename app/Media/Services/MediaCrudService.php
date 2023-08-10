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
    public function remove($id){
        return $this->media_crud_repository->remove($id);
    }

    public function UpdateMediaCollection($id,$collection){
        return $this->media_crud_repository->update_media_collection($id,$collection);
    }
    
    public function GetMediaByCollection($collection,$collection_id){
        return $this->media_crud_repository->get_media_by_collection($collection,$collection_id);
    }

    public function GetImagesByCollection($collection,$collection_id){
        return $this->media_crud_repository->get_images_by_collection($collection,$collection_id);
    }

}

