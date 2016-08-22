<?php

namespace FunnelCms\File;

class TmpFile
{
    private $rules;
    private $name;
    private $extension;
    private $size;
    private $source;
    private $contentType;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        if ( ! in_array($extension, $this->rules['extensions'])) {
            throw new \Exception('Enkel bestanden met de extensie jpg, png, gif of pdf zijn toegestaan.');
        }

        $this->extension = $extension;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        if ($size > $this->rules['maxSize']) {
            throw new \Exception("De bestandsgrootte mag niet groter zijn dan " . round($this->rules['maxSize'] / 1000000, 1) . "MB.");
        }

        $this->size = $size;

        return $this;
    }
}