<?php

namespace FunnelCms\Translator;


class Translator
{
    private $map;

    public function __construct($map) {
        $this->map = $map;
    }

    public function get($key) {
        return $this->map[$key];
    }
}