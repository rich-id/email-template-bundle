<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Adapter;

use RichId\EmailTemplateBundle\Domain\Port\MailerInterface;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

class MailerAdapter implements MailerInterface
{
    #[Required]
    public SymfonyMailerInterface $mailer;

    public function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}
