<?php

namespace FunnelCms\Page;

use FunnelCms\Helpers\ItemTemplate;

class Page extends ItemTemplate
{
    /**
     * Fillable fields for article.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_visible',
    ];

    public function isVisible() {
        return (bool) $this->is_visible;
    }

    public function isLocked() {
        return (bool) $this->is_locked;
    }
}