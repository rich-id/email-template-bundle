<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Attachment;

class Attachment
{
    private string $data;
    private string $filename;
    private string $contentType;

    public function __construct(string $data, string $filename, string $contentType)
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->contentType = $contentType;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }
}
