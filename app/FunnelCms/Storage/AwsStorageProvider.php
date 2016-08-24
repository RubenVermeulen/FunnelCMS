<?php

namespace FunnelCms\Storage;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

// TODO: Thumbnail support

class AwsStorageProvider implements StorageProvider
{
    private $s3;

    private $bucket;

    public function __construct(S3Client $s3, $bucket)
    {
        $this->s3 = $s3;
        $this->bucket = $bucket;
    }

    public function store($source, $destination = null, $name, $mimeType, $thumbnail = false)
    {
        try {
            return $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $name,
                'SourceFile' => $source,
                'ContentType' => $mimeType,
                'ACL' => 'public-read'
            ]);
        }
        catch (S3Exception $e) {
            throw new \Exception('Could not upload file');
        }
    }

    public function delete($path, $name)
    {
        $url = '';

        if ($path) {
            $url .= $path;
        }

        try {
            $this->s3->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $url . '/' . $name,
            ]);
        }
        catch (S3Exception $e) {
            throw new \Exception('Could not delete file');
        }
    }
}