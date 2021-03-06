<?php

namespace FunnelCms\Article;

use FunnelCms\Helpers\ItemTemplate;

class Article extends ItemTemplate
{
    /**
     * Fillable fields for article.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'summary',
        'content',
        'published_at'
    ];
}