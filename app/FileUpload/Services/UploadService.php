<?php

namespace App\FileUpload\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\Interfaces\UploadProductInterface;
use App\FileUpload\Interfaces\UploadProductMainInterface;
use App\FileUpload\Interfaces\UploadStockInterface;
use App\FileUpload\Interfaces\UploadStatusInterface;
use App\FileUpload\Interfaces\UploadTransactionInterface;
use App\FileUpload\Interfaces\UploadVarientInterface;
use App\FileUpload\DTO\File;

class UploadService implements UploadServiceInterface{

    public function __construct(
        private readonly UploadAvatarInterface $avatar,
        private readonly UploadBrandInterface $brand,
        private readonly UploadProductInterface $product,
        private readonly UploadProductMainInterface $product_main,
        private readonly UploadStockInterface $stock,
        private readonly UploadStatusInterface $status,
        private readonly UploadTransactionInterface $transaction,
        private readonly UploadVarientInterface $varient
    ) {}

    public function avatar($file,$company_id,$collection_id=NULL): File{
        return $this->avatar->handle($file,$company_id,$collection_id);
    }

    public function brand($file,$company_id,$collection_id=NULL): File{
        return $this->brand->handle($file,$company_id,$collection_id);
    }

    public function product($file,$company_id,$collection_id=NULL): File{
        return $this->product->handle($file,$company_id,$collection_id);
    }

    public function product_main($file,$company_id,$collection_id=NULL): File{
        return $this->product_main->handle($file,$company_id,$collection_id);
    }

    public function stock($file,$company_id,$collection_id=NULL): File{
        return $this->stock->handle($file,$company_id,$collection_id);
    }
    public function transaction($file,$company_id,$collection_id=NULL): File{
        return $this->transaction->handle($file,$company_id,$collection_id);
    }
    public function status($file,$company_id,$collection_id=NULL): File{
        return $this->status->handle($file,$company_id,$collection_id);
    }
    public function varient($file,$company_id,$collection_id=NULL): File{
        return $this->varient->handle($file,$company_id,$collection_id);
    }
}

