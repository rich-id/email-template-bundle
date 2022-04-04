<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\InvalidType;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;

class InvalidTypeEmail extends AbstractEmail
{
    public const SLUG = 'invalid_type';
    protected const BODY_TYPE = 'invalid_type';

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function getTo(): array
    {
        return ['test@test.test'];
    }
}
