<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Port;

interface MailerInterface
{
    public function send(\Swift_Message $message): int;
}
