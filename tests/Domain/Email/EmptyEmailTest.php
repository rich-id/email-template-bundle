<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Domain\Email;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Infrastructure\TestCase\EmailTestCase;
use RichId\EmailTemplateBundle\Tests\Resources\Email\Empty\EmptyEmail;
use RichId\EmailTemplateBundle\Tests\Resources\Email\Test1\Test1Model;

/**
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\Attachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\PdfAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XlsAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XmlAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Email\AbstractEmail
 * @covers \RichId\EmailTemplateBundle\Domain\Email\Trait\EmailDataTrait
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
final class EmptyEmailTest extends EmailTestCase
{
    protected function getEmailSlug(): string
    {
        return EmptyEmail::SLUG;
    }

    public function testEmailDefaultTemplate(): void
    {
        $email = $this->getEmail(Constant::DEFAULT_TEMPLATE, Test1Model::build('my value'));

        self::assertSame('Empty subject', $email->getSubject());

        self::assertCount(1, $email->getTo());
        self::assertSame('test@test.test', $email->getTo()[0]->getAddress());

        self::assertEmpty($email->getCc());
        self::assertEmpty($email->getBcc());
        self::assertEmpty($email->getFrom());
        self::assertEmpty($email->getAttachments());

        self::assertSame('Empty email content', $email->getHtmlBody());
    }
}
