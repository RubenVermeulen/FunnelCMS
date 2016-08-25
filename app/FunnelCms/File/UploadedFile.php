<?php

namespace FunnelCms\File;


use FunnelCms\Storage\StorageProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class UploadedFile
{
    private $file;
    private $storageProvider;

    public function __construct(SymfonyUploadedFile $file, StorageProvider $storageProvider)
    {
        $this->file = $file;
        $this->storageProvider = $storageProvider;
    }

    public function store($path = null, $thumbnail = true)
    {
        return $this->storageProvider->store(
            $this->file->getPathname(),
            $path,
            $this->hash(),
            $this->file->getClientMimeType(),
            $thumbnail
        );
    }

    private function hash()
    {
        $key = md5(uniqid(session_id()));

        return "{$key}.{$this->file->guessClientExtension()}";
    }
}