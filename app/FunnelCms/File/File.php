<?php


namespace FunnelCms\File;

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

    /**
     * Returns the type of file.
     *
     * @return string
     */
    public function getType() {
        $extension = explode('.', $this->name_system);
        $extension = strtolower(end($extension));

        switch ($extension) {
            case 'jpg': return 'image';
            case 'png': return 'image';
            case 'gif': return 'image';
            case 'pdf': return 'pdf';
        }

        return null;
    }

    public function getSizeInKiloByte() {
        return round($this->size / 1024, 0);
    }
}