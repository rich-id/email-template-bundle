<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Domain\Exception\EmailNotFoundException;
use RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager;
use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;
use Symfony\Contracts\Service\Attribute\Required;

final class EmailManager
{
    #[Required]
    public InternalEmailManager $internalEmailManager;

    public function getEmail(string $slug): AbstractEmail
    {
        $service = $this->internalEmailManager->getCurrentEmailService($slug);

        if ($service === null) {
            throw new EmailNotFoundException($slug);
        }

        return $service;
    }

    public function send(string $slug, ?EmailModelInterface $data = null): void
    {
        $this->getEmail($slug)
            ->setData($data)
            ->send();
    }
}
