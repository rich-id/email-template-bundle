<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Domain\Email;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Exception\MissingEmailParameterException;
use RichId\EmailTemplateBundle\Infrastructure\TestCase\EmailTestCase;
use RichId\EmailTemplateBundle\Tests\Resources\Email\Test1\OtherTest1Model;
use RichId\EmailTemplateBundle\Tests\Resources\Email\Test1\Test1Email;
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
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\TemplatingAdapter
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\TranslatorAdapter
 *
 */
#[TestConfig('fixtures')]
final class EmailTest extends EmailTestCase
{
    protected function getEmailSlug(): string
    {
        return Test1Email::SLUG;
    }

    public function testEmailWithMissingParameters(): void
    {
        self::expectException(MissingEmailParameterException::class);
        self::expectExceptionMessage('Missing parameters given for this email.');

        $this->getEmail();
    }

    public function testEmailDefaultTemplate(): void
    {
        $email = $this->getEmail(Constant::DEFAULT_TEMPLATE, Test1Model::build('my value'));

        self::assertSame('My subject', $email->getSubject());

        self::assertCount(1, $email->getTo());
        self::assertSame('test@test.test', $email->getTo()[0]->getAddress());

        self::assertCount(1, $email->getCc());
        self::assertSame('cc@test.test', $email->getCc()[0]->getAddress());

        self::assertCount(1, $email->getBcc());
        self::assertSame('bcc@test.test', $email->getBcc()[0]->getAddress());

        self::assertCount(1, $email->getFrom());
        self::assertSame('from@test.test', $email->getFrom()[0]->getAddress());

        self::assertCount(4, $email->getAttachments());
        self::assertSame('application/pdf disposition: attachment filename: test.pdf', $email->getAttachments()[0]->asDebugString());
        self::assertSame('custom content pdf', $email->getAttachments()[0]->getBody());

        self::assertSame('application/vnd.ms-excel disposition: attachment filename: test.xls', $email->getAttachments()[1]->asDebugString());
        self::assertSame('custom content xls', $email->getAttachments()[1]->getBody());

        self::assertSame('application/xml disposition: attachment filename: test.xml', $email->getAttachments()[2]->asDebugString());
        self::assertSame('custom content xml', $email->getAttachments()[2]->getBody());

        self::assertSame('text/plain disposition: attachment filename: test.txt', $email->getAttachments()[3]->asDebugString());
        self::assertSame('custom content txt', $email->getAttachments()[3]->getBody());

        self::assertSame('Email content with value: my value', $email->getHtmlBody());
    }

    public function testEmailOtherTemplate(): void
    {
        $email = $this->getEmail('other_template', Test1Model::build('my value'));

        self::assertSame('Other subject', $email->getSubject());

        self::assertCount(1, $email->getTo());
        self::assertSame('test@test.test', $email->getTo()[0]->getAddress());

        self::assertCount(1, $email->getCc());
        self::assertSame('cc@test.test', $email->getCc()[0]->getAddress());

        self::assertCount(1, $email->getBcc());
        self::assertSame('bcc@test.test', $email->getBcc()[0]->getAddress());

        self::assertCount(1, $email->getFrom());
        self::assertSame('from@test.test', $email->getFrom()[0]->getAddress());

        self::assertCount(4, $email->getAttachments());
        self::assertSame('application/pdf disposition: attachment filename: test.pdf', $email->getAttachments()[0]->asDebugString());
        self::assertSame('custom content pdf', $email->getAttachments()[0]->getBody());

        self::assertSame('application/vnd.ms-excel disposition: attachment filename: test.xls', $email->getAttachments()[1]->asDebugString());
        self::assertSame('custom content xls', $email->getAttachments()[1]->getBody());

        self::assertSame('application/xml disposition: attachment filename: test.xml', $email->getAttachments()[2]->asDebugString());
        self::assertSame('custom content xml', $email->getAttachments()[2]->getBody());

        self::assertSame('text/plain disposition: attachment filename: test.txt', $email->getAttachments()[3]->asDebugString());
        self::assertSame('custom content txt', $email->getAttachments()[3]->getBody());

        self::assertSame('Other email content with value: my value', $email->getHtmlBody());
    }

    public function testEmailNewTemplateInvalidModel(): void
    {
        self::expectException(MissingEmailParameterException::class);
        self::expectExceptionMessage('Missing parameters given for this email.');

        $this->getEmail('new_template', Test1Model::build('my value'));
    }

    public function testEmailNewTemplate(): void
    {
        $email = $this->getEmail('new_template', OtherTest1Model::build('my value'));

        self::assertSame('New subject', $email->getSubject());

        self::assertCount(1, $email->getTo());
        self::assertSame('new-test@test.test', $email->getTo()[0]->getAddress());

        self::assertCount(1, $email->getCc());
        self::assertSame('new-cc@test.test', $email->getCc()[0]->getAddress());

        self::assertCount(1, $email->getBcc());
        self::assertSame('new-bcc@test.test', $email->getBcc()[0]->getAddress());

        self::assertCount(1, $email->getFrom());
        self::assertSame('new-from@test.test', $email->getFrom()[0]->getAddress());

        self::assertEmpty($email->getAttachments());

        self::assertSame("New email content with value: my value\n", $email->getHtmlBody());
    }
}
