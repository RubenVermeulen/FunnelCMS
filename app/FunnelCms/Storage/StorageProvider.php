<?php

namespace FunnelCms\Storage;

interface StorageProvider
{
    public function store($source, $destination = null, $name, $thumbnail = false);
    public function delete($name);
}