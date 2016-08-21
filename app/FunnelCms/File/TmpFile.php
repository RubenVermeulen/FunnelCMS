<?php

namespace FunnelCms\File;


class TmpFile
{
    private $newName;
    private $extension;
    private $source;
    private $contentType;

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

    public function getNewName()
    {
        return $this->newName;
    }

    public function setNewName($newName)
    {
        $this->newName = $newName;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }


}