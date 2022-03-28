<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Adapter;

use RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration;
use RichId\EmailTemplateBundle\Domain\Port\EmailTemplateRepositoryInterface;
use RichId\EmailTemplateBundle\Infrastructure\Repository\EmailTemplateConfigurationRepository;
use Symfony\Contracts\Service\Attribute\Required;

class EmailTemplateRepositoryAdapter implements EmailTemplateRepositoryInterface
{
    #[Required]
    public EmailTemplateConfigurationRepository $emailTemplateConfigurationRepository;

    public function getEmailTemplateConfigurationFor(string $slug): ?EmailTemplateConfiguration
    {
        return $this->emailTemplateConfigurationRepository->findOneBySlug($slug);
    }
}
