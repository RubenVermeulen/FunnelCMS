<?php

namespace FunnelCms\Storage;

use FunnelCms\Helpers\Image;
use Intervention\Image\ImageManager;

class LocalStorageProvider implements StorageProvider
{
    private $sourceLocal = INC_ROOT . '/public/storage';

    public function store($source, $destination = null, $name, $mimeType, $thumbnail = false)
    {
        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make($source);
        $url = $this->sourceLocal;

        if (isset($destination)) {
            $url .= '/' . $destination;

            $this->createDirectory($url);
        }

        // Original
        $image->save($url . '/' . $name);

        // Thumbnail
        if ($thumbnail && Image::isImage($source)) {
            $this->createDirectory($url . '/thumbs/');

            Image::resizeImage($image, 350);

            $image->save($url . '/thumbs/' . $name);
        }

        return ($destination != null ? $destination . '/' : '') . $name;
    }

    public function createDirectory($path, $mode = 0777, $recursive = true) {
        if ( ! file_exists($path)) {
            mkdir($path, $mode, $recursive);
        }
    }

    public function delete($path, $name)
    {
        $url = $this->sourceLocal;

        if ($path) {
            $url .= '/' . $path;
        }

        // Original
        $sourceOriginal = $url . '/' . $name;

        if (file_exists($sourceOriginal)) {
            unlink($sourceOriginal);
        }

        // Thumbnail
        $sourceThumbnail = $url . '/thumbs/' . $name;

        if (file_exists($sourceThumbnail)) {
            unlink($sourceThumbnail);
        }
    }
}