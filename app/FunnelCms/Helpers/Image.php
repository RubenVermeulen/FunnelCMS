<?php
/**
 * Created by PhpStorm.
 * User: Ruben
 * Date: 23/08/2016
 * Time: 17:40
 */

namespace FunnelCms\Helpers;


class Image
{
    public static function isImage($source) {
        return getimagesize($source);
    }
}