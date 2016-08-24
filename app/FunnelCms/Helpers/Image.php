<?php

namespace FunnelCms\Helpers;

use Intervention\Image\Image as InterventionImage;

class Image
{
    /**
     * Check if source is an image.
     *
     * @param $source
     * @return array
     */
    public static function isImage($source)
    {
        return getimagesize($source);
    }

    /**
     * Resizes image.
     *
     * @param InterventionImage $image
     * @param $size
     */
    public static function resizeImage(InterventionImage $image, $size)
    {
        if ($image->width() >= $image->height() && $image->height() > $size) {
            $image->resize(null, $size, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else if ($image->width() < $image->height() && $image->width() > $size) {
            $image->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
    }
}