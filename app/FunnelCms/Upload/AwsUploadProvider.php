<?php

namespace FunnelCms\Upload;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use FunnelCms\File\TmpFile;

class AwsUploadProvider implements UploadProvider
{
    private $s3;

    private $bucket;

    public function __construct(S3Client $s3, $bucket)
    {
        $this->s3 = $s3;
        $this->bucket = $bucket;
    }

    public function upload(TmpFile $tmpFile)
    {
        try {
            return $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $tmpFile->getNewName(),
                'SourceFile'   => $tmpFile->getSource(),
                'ContentType'   => $tmpFile->getContentType(),
                'ACL' => 'public-read'
            ]);
        }
        catch (S3Exception $e) {
            throw new \Exception('Could not upload file');
        }
    }

    public function delete($name)
    {
        try {
            $this->s3->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $name,
            ]);
        }
        catch (S3Exception $e) {
            throw new \Exception('Could not delete file');
        }
    }
}