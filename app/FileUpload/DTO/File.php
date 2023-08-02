<?php

namespace App\FileUpload\DTO;

class File
{
    public function __construct(
        public readonly string $name,
        public readonly string $file_name,
        public readonly string $mime,
        public readonly string $path,
        public readonly string $disk,
        public readonly string $hash,
        public readonly string $company_id,
        public readonly null|string $collection = null,
        public readonly null|string $collection_id = null,
    ) {}
 
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime,
            'path' => $this->path,
            'disk' => $this->disk,
            'file_hash' => $this->hash,
            'company_id' => $this->company_id,
            'collection' => $this->collection,
            'collection_id' => $this->collection_id,
        ];
    }
}
