<?php

namespace FunnelCms\Article;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Article extends Eloquent
{
    /**
     * Fillable fields for article.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'published_at'
    ];

    /**
     * Custom fields which should be treated as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['published_at'];
}