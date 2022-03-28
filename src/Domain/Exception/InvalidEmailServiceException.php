<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Exception;

class InvalidEmailServiceException extends \LogicException
{
    protected string $emailClass;
    protected string $template;

    public function __construct(string $emailClass, string $template)
    {
        parent::__construct(\sprintf('Email service %s does not support template %s', $emailClass, $template));

        $this->emailClass = $emailClass;
        $this->template = $template;
    }

    public function getEmailClass(): string
    {
        return $this->emailClass;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
