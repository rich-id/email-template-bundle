<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\TestCase;

use RichCongress\FixtureTestBundle\Generator\StaticGenerator;
use RichCongress\TestSuite\TestCase\TestCase;
use RichCongress\TestTools\Helper\ForceExecutionHelper;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\EmailManager;
use RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration;
use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;
use RichId\EmailTemplateBundle\Infrastructure\Repository\EmailTemplateConfigurationRepository;
use Symfony\Component\Mime\Email;

abstract class EmailTestCase extends TestCase
{
    abstract protected function getEmailSlug(): string;

    public static function assertEmailBody(string $expected, Email $email): void
    {
        static::assertSame(\rtrim($expected), \rtrim((string) $email->getHtmlBody()));
    }

    protected function getEmail(string $template = Constant::DEFAULT_TEMPLATE, ?EmailModelInterface $data = null): ?Email
    {
        $this->setSpecificTemplate($template);

        /** @var EmailManager $emailManager */
        $emailManager = $this->getService(EmailManager::class);

        $email = $emailManager
            ->getEmail($this->getEmailSlug())
            ->setData($data);

        return ForceExecutionHelper::executeMethod($email, 'getEmail');
    }

    private function setSpecificTemplate(string $template): void
    {
        /** @var EmailTemplateConfigurationRepository $repository */
        $repository = $this->getRepository(EmailTemplateConfiguration::class);
        $configuration = $repository->findOneBySlug($this->getEmailSlug());

        if (!$configuration instanceof EmailTemplateConfiguration) {
            $configuration = StaticGenerator::make(
                EmailTemplateConfiguration::class,
                ['slug' => $this->getEmailSlug()]
            );
        }

        ForceExecutionHelper::setValue($configuration, 'value', $template);

        $this->getManager()->persist($configuration);
        $this->getManager()->flush();
    }
}
