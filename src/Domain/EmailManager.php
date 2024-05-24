<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Domain\Exception\EmailNotFoundException;
use RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager;
use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;
use RichId\EmailTemplateBundle\Domain\Port\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class EmailManager
{
    #[Required]
    public InternalEmailManager $internalEmailManager;

    #[Required]
    public MailerInterface $mailer;

    /** @phpstan-ignore-next-line */
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
        $email = $this->generateEmail($slug, $data);

        if ($email === null) {
            return;
        }

        $this->mailer->send($email);
    }

    public function sendEmail(Email $email): void
    {
        $this->mailer->send($email);
    }

    public function getEmailContent(string $slug, ?EmailModelInterface $data = null): ?string
    {
        $email = $this->generateEmail($slug, $data);
        $body = $email?->getHtmlBody();

        return !empty($body) ? (string) $body : null;
    }

    public function generateEmail(string $slug, ?EmailModelInterface $data = null): ?Email
    {
        $emailService = $this->getEmail($slug);

        $method = new \ReflectionMethod($emailService, 'getEmail');
        $method->setAccessible(true);

        $email = $method->invoke($emailService->setData($data));
        $method->setAccessible(false);

        return $email;
    }
}
