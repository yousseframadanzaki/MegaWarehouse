<?php 

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;
interface UploadServiceInterface{
    public function avatar($file,$collection_id=NULL): File;
    public function brand($file,$collection_id=NULL): File;
    public function product($file,$collection_id=NULL): File;
    public function product_main($file,$collection_id=NULL): File;
}