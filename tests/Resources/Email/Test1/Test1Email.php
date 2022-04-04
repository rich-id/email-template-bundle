<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\Test1;

use RichId\EmailTemplateBundle\Domain\Attachment\Attachment;
use RichId\EmailTemplateBundle\Domain\Attachment\PdfAttachment;
use RichId\EmailTemplateBundle\Domain\Attachment\XlsAttachment;
use RichId\EmailTemplateBundle\Domain\Attachment\XmlAttachment;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Domain\Exception\MissingEmailParameterException;

class Test1Email extends AbstractEmail
{
    public const SLUG = 'test_1';
    public const TEMPLATES = [Constant::DEFAULT_TEMPLATE, 'other_template'];

    public function getEmailSlug(): string
    {
        return self::SLUG;
    }

    protected function assertValidParameters(): void
    {
        if (!$this->data instanceof Test1Model) {
            throw new MissingEmailParameterException();
        }
    }

    protected function getTo(): array
    {
        return ['test@test.test'];
    }

    protected function getCc(): array
    {
        return ['cc@test.test'];
    }

    protected function getBcc(): array
    {
        return ['bcc@test.test'];
    }

    protected function getFrom(): array
    {
        return ['from@test.test'];
    }

    protected function getAttachments(): array
    {
        return [
            PdfAttachment::build('custom content pdf', 'test.pdf'),
            XlsAttachment::build('custom content xls', 'test.xls'),
            XmlAttachment::build('custom content xml', 'test.xml'),
            new Attachment('custom content txt', 'test.txt', 'text/plain'),
        ];
    }

    protected function customBodyParameters(): array
    {
        return [
            '%value%' => $this->data->getValue(),
        ];
    }
}
