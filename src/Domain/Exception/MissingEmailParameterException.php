<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Exception;

class MissingEmailParameterException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Missing parameters given for this email.');
    }
}
