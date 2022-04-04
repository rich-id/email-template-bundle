<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\Test1;

use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Domain\Exception\MissingEmailParameterException;

class OtherTest1Email extends AbstractEmail
{
    public const SLUG = 'test_1';
    public const TEMPLATES = ['new_template'];
    public const BODY_TYPE = self::BODY_TYPE_TWIG;

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function assertValidParameters(): void
    {
        if (!$this->data instanceof OtherTest1Model) {
            throw new MissingEmailParameterException();
        }
    }

    protected function getTo(): array
    {
        return ['new-test@test.test'];
    }

    protected function getCc(): array
    {
        return ['new-cc@test.test'];
    }

    protected function getBcc(): array
    {
        return ['new-bcc@test.test'];
    }

    protected function getFrom(): array
    {
        return ['new-from@test.test'];
    }

    protected function customBodyParameters(): array
    {
        return [
            'value' => $this->data->getValue(),
        ];
    }
}
