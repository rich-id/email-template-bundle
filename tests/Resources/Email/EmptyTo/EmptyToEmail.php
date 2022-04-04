<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\EmptyTo;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;

class EmptyToEmail extends AbstractEmail
{
    public const SLUG = 'empty_to';

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function getTo(): array
    {
        return [];
    }
}
