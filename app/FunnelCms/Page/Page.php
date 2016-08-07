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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_visible' => 'boolean',
        'is_locked' => 'boolean',
    ];
}