<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Internal;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Domain\Fetcher\EmailTemplateFetcher;
use Symfony\Contracts\Service\Attribute\Required;

final class InternalEmailManager
{
    /** @var AbstractEmail[] */
    public array $emails;

    #[Required]
    public EmailTemplateFetcher $emailTemplateFetcher;

    public function getCurrentEmailService(string $slug): ?AbstractEmail
    {
        $services = $this->getAllEmailServicesFor($slug);
        $template = ($this->emailTemplateFetcher)($slug);

        foreach ($services as $service) {
            if ($service->supportTemplate($template)) {
                return $service;
            }
        }

        return null;
    }

    /** @return AbstractEmail[] */
    public function getAllEmailServicesFor(string $slug): array
    {
        return \array_filter(
            $this->emails,
            static function (AbstractEmail $email) use ($slug) {
                return $email->getEmailSlug() === $slug;
            }
        );
    }
}
