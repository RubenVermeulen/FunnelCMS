<?php

namespace FunnelCms\Upload;

use FunnelCms\File\TmpFile;

interface UploadProvider
{
    public function upload(TmpFile $tmpFile);
    public function delete($name);
}