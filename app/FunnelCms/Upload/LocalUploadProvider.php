<?php

namespace FunnelCms\Upload;

use FunnelCms\File\TmpFile;
use FunnelCms\Helpers\Image;
use Intervention\Image\ImageManager;

class LocalUploadProvider implements UploadProvider
{
    private $sourceLocal = INC_ROOT . '/public/assets/files/';
    private $sourceLocalThumbs = INC_ROOT . '/public/assets/files/thumbs/';

    public function upload(TmpFile $tmpFile)
    {
        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make($tmpFile->getSource());

        // Original
        $image->save($this->sourceLocal . $tmpFile->getName());

        // Thumbnail
        if (Image::isImage($tmpFile->getSource())) {
            $minSize = 350;

            if ($image->width() >= $image->height() && $image->height() > $minSize) {
                $image->resize(null, $minSize, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            else if ($image->width() < $image->height() && $image->width() > $minSize) {
                $image->resize($minSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $image->save($this->sourceLocalThumbs . $tmpFile->getName());
        }
    }

    public function delete($name)
    {
        // Original
        $sourceOriginal = $this->sourceLocal . $name;

        if (file_exists($sourceOriginal)) {
            unlink($sourceOriginal);
        }

        // Thumbnail
        $sourceThumbnail = $this->sourceLocalThumbs . $name;

        if (file_exists($sourceThumbnail)) {
            unlink($sourceThumbnail);
        }
    }
}