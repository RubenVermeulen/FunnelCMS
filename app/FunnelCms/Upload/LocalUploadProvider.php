<?php

namespace FunnelCms\Upload;

use FunnelCms\File\TmpFile;

class LocalUploadProvider implements UploadProvider
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function upload(TmpFile $tmpFile)
    {
        $newFilePath = INC_ROOT . "/{$this->config->get('upload.local.filePath')}/{$tmpFile->getNewName()}";

        move_uploaded_file($tmpFile->getSource(), $newFilePath);
    }

    public function delete($name)
    {
        // TODO: Implement delete() method.
    }
}