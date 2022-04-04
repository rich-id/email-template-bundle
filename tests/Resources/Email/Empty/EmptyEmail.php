<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\Empty;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;

class EmptyEmail extends AbstractEmail
{
    public const SLUG = 'empty';

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function getTo(): array
    {
        return ['test@test.test'];
    }
}
