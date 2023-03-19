<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Domain\Email;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichId\EmailTemplateBundle\Infrastructure\TestCase\EmailTestCase;
use RichId\EmailTemplateBundle\Tests\Resources\Email\EmptyTo\EmptyToEmail;

/**
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\Attachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\PdfAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XlsAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XmlAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Email\AbstractEmail
 * @covers \RichId\EmailTemplateBundle\Domain\EmailManager
 * @covers \RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration
 * @covers \RichId\EmailTemplateBundle\Domain\Exception\MissingEmailParameterException
 * @covers \RichId\EmailTemplateBundle\Domain\Fetcher\EmailTemplateFetcher
 * @covers \RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\EmailTemplateRepositoryAdapter
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\MailerAdapter
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\TemplatingAdapter
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\TranslatorAdapter
 *
 */
#[TestConfig('fixtures')]
final class EmptyToEmailTest extends EmailTestCase
{
    protected function getEmailSlug(): string
    {
        return EmptyToEmail::SLUG;
    }

    public function testEmailDefaultTemplate(): void
    {
        $email = $this->getEmail();
        self::assertNull($email);
    }
}
