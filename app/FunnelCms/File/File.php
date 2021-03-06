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
        'path',
        'name_system',
        'name_human',
        'size'
    ];

    public function getSizeInKiloByte() {
        return round($this->size / 1024, 0);
    }

    public function getUrl() {
        return ($this->path ? $this->path . '/' : '') . $this->name_system;
    }

    public function getUrlThumbnail() {
        return ($this->path ? $this->path . '/' : '') . 'thumbs/' . $this->name_system;
    }

    public function isImage() {
        $ext = explode('.', $this->name_system);

        return ! (end($ext) == 'pdf');
    }
}