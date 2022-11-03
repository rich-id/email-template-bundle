<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\Skipped;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;

class SkippedEmail extends AbstractEmail
{
    public const SLUG = 'skipped';

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function getTo(): array
    {
        return ['test@test.test'];
    }

    protected function skippedIf(): bool
    {
        return true;
    }
}
