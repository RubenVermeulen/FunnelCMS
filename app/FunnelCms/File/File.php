<?php


namespace FunnelCms\File;

use FunnelCms\Helpers\Image;
use Illuminate\Database\Eloquent\Model as Eloquent;

class File extends Eloquent
{
    /**
     * Fillable fields for article.
     *
     * @var array
     */
    protected $fillable = [
        'name_system',
        'name_human',
        'size'
    ];

    public function getSizeInKiloByte() {
        return round($this->size / 1024, 0);
    }

    public function getUrl() {
        return SOURCE_UPLOADS . '/' . $this->name_system;
    }

    public function getUrlThumbnail() {
        if ($this->isImage()) {
            return SOURCE_UPLOADS_THUMBS . '/' . $this->name_system;
        }

        return null;
    }

    public function isImage() {
        return Image::isImage($this->getUrl());
    }
}