<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Adapter;

use RichId\EmailTemplateBundle\Domain\Port\MailerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class MailerAdapter implements MailerInterface
{
    #[Required]
    public \Swift_Mailer $mailer;

    public function send(\Swift_Message $message): int
    {
        return $this->mailer->send($message);
    }
}
