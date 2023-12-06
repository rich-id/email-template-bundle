<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Fetcher;

use RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager;
use RichId\EmailTemplateBundle\Domain\Model\AdministrationEmailModel;
use Symfony\Contracts\Service\Attribute\Required;

final class AdministrationEmailsFetcher
{
    #[Required]
    public InternalEmailManager $internalEmailManager;

    #[Required]
    public EmailTemplateFetcher $emailTemplateFetcher;

    /** @return AdministrationEmailModel[] */
    public function __invoke(): array
    {
        $models = [];

        foreach ($this->internalEmailManager->emails as $email) {
            if (!$email->canSeeEmailInAdministration()) {
                continue;
            }

            if (!isset($models[$email->getEmailSlug()])) {
                $models[$email->getEmailSlug()] = AdministrationEmailModel::build(
                    $email->getEmailSlug(),
                    $email->getName(),
                    ($this->emailTemplateFetcher)($email->getEmailSlug()),
                    $email::TEMPLATES
                );

                continue;
            }

            $models[$email->getEmailSlug()]->allowedValues = \array_unique(
                \array_merge($models[$email->getEmailSlug()]->allowedValues, $email::TEMPLATES)
            );
        }

        return \array_values($models);
    }
}
