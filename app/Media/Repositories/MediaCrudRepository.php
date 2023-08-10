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
    
    public function remove($id){
        return Media::destroy($id);
    }

    public function update_media_collection($id,$collection){
        return Media::where(['id' => $id ])->update(['collection' => $collection]);
    }
    
    public function get_media_by_collection($collection,$collection_id){
        return Media::where(['collection' => $collection,'collection_id'=>$collection_id])->first();
    }

    public function get_images_by_collection($collection,$collection_id){
        return Media::where(['collection' => $collection,'collection_id'=>$collection_id])->get();
    }
}
