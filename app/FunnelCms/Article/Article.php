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
        'summary',
        'content',
        'published_at'
    ];

    /**
     * Custom fields which should be treated as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * Default date format.
     *
     * @var string
     */
    private $formatDate = 'Y-m-d';

    /**
     * Default time format.
     *
     * @var string
     */
    private $formatTime = 'H:i';

    /**
     * Belongs to a User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() {
        return $this->belongsTo('FunnelCms\User\User', 'user_id');
    }

    /**
     * Return datetime for given field.
     *
     * @param $field
     * @return mixed
     */
    public function getDatetime($field) {
        return $this->{$field}->format('d/m/Y H:i');
    }

    /**
     * Return datetime for created at.
     *
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->getDatetime('created_at');
    }

    /**
     * Return datetime for updated at.
     *
     * @return mixed
     */
    public function getUpdatedAt() {
        return $this->getDatetime('updated_at');
    }

    /**
     * Return datetime for published at.
     *
     * @return mixed
     */
    public function getPublishedAt() {
        return $this->getDatetime('published_at');
    }

    /**
     * Return date for given field.
     *
     * @param $field
     * @param $format
     * @return mixed
     */
    public function getDate($field, $format) {
        if ( ! $format)
            $format = $this->formatDate;

        return $this->{$field}->format($format);
    }

    /**
     * Return date for created at.
     *
     * @param null $format
     * @return mixed
     */
    public function getCreatedAtDate($format = null) {
        return $this->getDate('created_at', $format);
    }

    /**
     * Return date for updated at.
     *
     * @param null $format
     * @return mixed
     */
    public function getUpdatedAtDate($format = null) {
        return $this->getDate('updated_at', $format);
    }

    /**
     * Return date for published at.
     *
     * @param null $format
     * @return mixed
     */
    public function getPublishedAtDate($format = null) {
        return $this->getDate('published_at', $format);
    }

    /**
     * Return time for given field.
     *
     * @param $field
     * @param $format
     * @return mixed
     */
    public function getTime($field, $format) {
        if ( ! $format)
            $format = $this->formatTime;

        return $this->{$field}->format($format);
    }

    /**
     * Return time for created at.
     *
     * @param null $format
     * @return mixed
     */
    public function getCreatedAtTime($format = null) {
        return $this->getTime('created_at', $format);
    }

    /**
     * Return time for updated at.
     *
     * @param null $format
     * @return mixed
     */
    public function getUpdatedAtTime($format = null) {
        return $this->getTime('updated_at', $format);
    }

    /**
     * Return time for published at.
     *
     * @param null $format
     * @return mixed
     */
    public function getPublishedAtTime($format = null) {
        return $this->getTime('published_at', $format);
    }
}