<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Port;

use Symfony\Component\Mime\Email;

interface MailerInterface
{
    public function send(Email $email): void;
}
