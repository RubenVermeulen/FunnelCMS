<?php

namespace FunnelCms\Newsletter;

use FunnelCms\Helpers\ItemTemplate;

class Newsletter extends ItemTemplate
{
    /**
     * Fillable fields for article.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'receivers',
        'published_at'
    ];
}