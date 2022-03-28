<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Fetcher;

use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration;
use RichId\EmailTemplateBundle\Domain\Port\EmailTemplateRepositoryInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class EmailTemplateFetcher
{
    #[Required]
    public EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __invoke(string $slug): string
    {
        $configuration = $this->emailTemplateRepository->getEmailTemplateConfigurationFor($slug);

        return $configuration instanceof EmailTemplateConfiguration ? $configuration->getValue() : Constant::DEFAULT_TEMPLATE;
    }
}
