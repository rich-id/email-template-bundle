<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Email;

interface EmailCategoryInterface
{
    public function getSlug(): string;
}
