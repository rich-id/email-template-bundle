<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Exception;

class EmailNotFoundException extends \Exception
{
    protected string $slug;

    public function __construct(string $slug)
    {
        parent::__construct(\sprintf('No email found for the given slug %s.', $slug));

        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
