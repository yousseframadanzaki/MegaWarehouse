<?php

namespace App\FileUpload\Interfaces;
use App\FileUpload\DTO\File;
interface UploadServiceInterface{
    public function avatar($file,$company_id,$collection_id=NULL): File;
    public function brand($file,$company_id,$collection_id=NULL): File;
    public function product($file,$company_id,$collection_id=NULL): File;
    public function product_main($file,$company_id,$collection_id=NULL): File;
    public function transaction($file,$company_id,$collection_id=NULL): File;
}
