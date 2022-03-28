<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Attachment;

final class Attachment extends \Swift_Attachment
{
    public static function build(mixed $data, string $filename, string $contentType): self
    {
        return new self($data, $filename, $contentType);
    }
}
