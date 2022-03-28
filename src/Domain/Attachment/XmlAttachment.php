<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Attachment;

final class XmlAttachment extends \Swift_Attachment
{
    public static function build(mixed $data, string $filename): self
    {
        return new self($data, $filename, 'application/xml');
    }
}
