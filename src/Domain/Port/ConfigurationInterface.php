<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Port;

interface ConfigurationInterface
{
    public function getTranslationPrefix(): string;
}
