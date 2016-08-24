<?php

namespace FunnelCms\File;

use FunnelCms\Storage\StorageProvider;

class TmpFile
{
    private $uploadProvider;
    private $rules;
    private $name;
    private $extension;
    private $size;
    private $source;
    private $contentType;
    private $error;

    public function __construct($rules, $file, StorageProvider $uploadProvider)
    {
        $this->rules = $rules;

        $this->setError($file['error']);
        $this->setName($file['name']);
        $this->setExtension($this->getName());
        $this->setSize($file['size']);
        $this->setSource($file['tmp_name']);
        $this->setContentType(mime_content_type($this->getName()));

        $this->uploadProvider = $uploadProvider;

    }

    public function store($path) {

    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        if ($error != 0) {
            throw new \Exception('Je hebt nog geen bestand gekozen.');
        }

        $this->error = $error;

        return $this;
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

    public function setExtension($name)
    {
        $ext = explode('.', $name);
        $ext = strtolower(end($ext));

        if ( ! in_array($ext, $this->rules['extensions'])) {
            throw new \Exception('Enkel bestanden met de extensie jpg, png, gif of pdf zijn toegestaan.');
        }

        $this->extension = $ext;

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