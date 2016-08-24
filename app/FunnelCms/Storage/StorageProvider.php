<?php

namespace FunnelCms\Storage;

interface StorageProvider
{
    public function store($source, $destination = null, $name, $mimeType, $thumbnail = false);
    public function delete($path, $name);
}