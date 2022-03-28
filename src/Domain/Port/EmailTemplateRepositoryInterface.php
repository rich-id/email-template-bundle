<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Port;

use RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration;

interface EmailTemplateRepositoryInterface
{
    public function getEmailTemplateConfigurationFor(string $slug): ?EmailTemplateConfiguration;
}
