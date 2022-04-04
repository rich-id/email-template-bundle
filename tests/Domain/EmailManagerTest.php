<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Domain;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\EmailTemplateBundle\Domain\EmailManager;
use RichId\EmailTemplateBundle\Domain\Exception\EmailNotFoundException;
use RichId\EmailTemplateBundle\Domain\Exception\MissingEmailParameterException;
use RichId\EmailTemplateBundle\Tests\Resources\Email\Test1\Test1Model;
use Symfony\Component\Mime\Email;

/**
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\Attachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\PdfAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XlsAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Attachment\XmlAttachment
 * @covers \RichId\EmailTemplateBundle\Domain\Email\AbstractEmail
 * @covers \RichId\EmailTemplateBundle\Domain\Email\Trait\EmailDataTrait
 * @covers \RichId\EmailTemplateBundle\Domain\EmailManager
 * @covers \RichId\EmailTemplateBundle\Domain\Exception\EmailNotFoundException
 * @covers \RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager
 * @covers \RichId\EmailTemplateBundle\Infrastructure\Adapter\MailerAdapter
 *
 */
#[TestConfig('fixtures')]
final class EmailManagerTest extends TestCase
{
    public EmailManager $emailManager;

    public function testSendEmailNotFound(): void
    {
        self::expectException(EmailNotFoundException::class);
        self::expectExceptionMessage('No email found for the given slug other.');

        $this->emailManager->send('other');
    }

    public function testSendWithMissingParameters(): void
    {
        self::expectException(MissingEmailParameterException::class);
        self::expectExceptionMessage('Missing parameters given for this email.');

        $this->emailManager->send('test_1');
    }

    public function testSend(): void
    {
        $this->emailManager->send('test_1', Test1Model::build('my value'));

        $messageEvents = $this->getService('mailer.message_logger_listener')->getEvents()->getEvents();

        self::assertCount(1, $messageEvents);

        /** @var Email $email */
        $email = $messageEvents[0]->getMessage();
        self::assertSame('My subject', $email->getSubject());
    }

    public function testSendEmptyTo(): void
    {
        $this->emailManager->send('empty_to');

        $messageEvents = $this->getService('mailer.message_logger_listener')->getEvents()->getEvents();
        self::assertEmpty($messageEvents);
    }
}
