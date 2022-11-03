<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Domain\Fetcher;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\EmailTemplateBundle\Domain\Fetcher\AdministrationEmailsFetcher;

/**
 * @covers \RichId\EmailTemplateBundle\Domain\Fetcher\AdministrationEmailsFetcher
 * @covers \RichId\EmailTemplateBundle\Domain\Fetcher\EmailTemplateFetcher
 * @covers \RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager
 * @covers \RichId\EmailTemplateBundle\Domain\Model\AdministrationEmailModel
 * @covers \RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration
 */
#[TestConfig('fixtures')]
final class AdministrationEmailsFetcherTest extends TestCase
{
    public AdministrationEmailsFetcher $administrationEmailsFetcher;

    public function testFetcher(): void
    {
        $emails = ($this->administrationEmailsFetcher)();

        self::assertCount(5, $emails);

        self::assertSame('Email with empty data', $emails[0]->name);
        self::assertSame('empty', $emails[0]->slug);
        self::assertSame('default', $emails[0]->value);
        self::assertSame(['default'], $emails[0]->allowedValues);

        self::assertSame('Email with empty to', $emails[1]->name);
        self::assertSame('empty_to', $emails[1]->slug);
        self::assertSame('default', $emails[1]->value);
        self::assertSame(['default'], $emails[1]->allowedValues);

        self::assertSame('Invalid type email', $emails[2]->name);
        self::assertSame('invalid_type', $emails[2]->slug);
        self::assertSame('default', $emails[2]->value);
        self::assertSame(['default'], $emails[2]->allowedValues);

        self::assertSame('Skipped email', $emails[3]->name);
        self::assertSame('skipped', $emails[3]->slug);
        self::assertSame('default', $emails[3]->value);
        self::assertSame(['default'], $emails[3]->allowedValues);

        self::assertSame('Email 1', $emails[4]->name);
        self::assertSame('test_1', $emails[4]->slug);
        self::assertSame('default', $emails[4]->value);
        self::assertSame(['new_template', 'default', 'other_template'], $emails[4]->allowedValues);
    }
}
