<?php

namespace FunnelCms\File;


use FunnelCms\Storage\StorageProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class UploadedFile
{
    private $file;
    private $storageProvider;
    private $allowedExtensions = ['jpeg', 'png', 'gif', 'pdf'];
    private $maxFileSize = 500000;


    public function __construct(SymfonyUploadedFile $file, StorageProvider $storageProvider)
    {
        if ($file->getError() != UPLOAD_ERR_OK)
            throw new \Exception('Could not upload file');

        if ( ! in_array(strtolower($file->guessClientExtension()), $this->allowedExtensions))
            throw new \Exception('Extension not allowed');

        if ($file->getClientSize() > $this->maxFileSize)
            throw new \Exception('File is to big');

        $this->file = $file;
        $this->storageProvider = $storageProvider;
    }

    public function store($path = null, $thumbnail = true)
    {
        return $this->storageProvider->store($this->file->getPathname(), $path, $this->hash(), $thumbnail);
    }

    private function hash()
    {
        $key = md5(uniqid(session_id()));

        return "{$key}.{$this->file->guessClientExtension()}";
    }
}