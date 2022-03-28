<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Email;

use RichId\EmailTemplateBundle\Domain\Attachment\Attachment;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Email\Trait\EmailDataTrait;
use RichId\EmailTemplateBundle\Domain\Exception\InvalidEmailServiceException;
use RichId\EmailTemplateBundle\Domain\Fetcher\EmailTemplateFetcher;
use RichId\EmailTemplateBundle\Domain\Port\ConfigurationInterface;
use RichId\EmailTemplateBundle\Domain\Port\MailerInterface;
use RichId\EmailTemplateBundle\Domain\Port\TemplatingInterface;
use RichId\EmailTemplateBundle\Domain\Port\TranslatorInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractEmail
{
    use EmailDataTrait;

    public const TEMPLATES = [Constant::DEFAULT_TEMPLATE];
    protected const BODY_TYPE = self::BODY_TYPE_TRANSLATION;

    protected const BODY_TYPE_TRANSLATION = 'translation';
    protected const BODY_TYPE_TWIG = 'twig';

    #[Required]
    public ConfigurationInterface $configuration;

    #[Required]
    public MailerInterface $mailer;

    #[Required]
    public TemplatingInterface $templating;

    #[Required]
    public TranslatorInterface $translator;

    #[Required]
    public EmailTemplateFetcher $emailTemplateFetcher;

    abstract public function getEmailSlug(): string;

    /** @return string[] */
    abstract protected function getTo(): array;

    protected function assertValidParameters(): void
    {
    }

    public function getName(): string
    {
        return $this->translator->trans(
            \sprintf('%s.name', $this->getEmailSlug()),
            [],
            $this->configuration->getTranslationPrefix()
        );
    }

    /** @return string[] */
    protected function getCc(): array
    {
        return [];
    }

    /** @return string[] */
    protected function getFrom(): array
    {
        return [];
    }

    /** @return Attachment[] */
    protected function getAttachments(): array
    {
        return [];
    }

    protected function getSubject(): string
    {
        return $this->translator->trans(
            \sprintf('%s.%s.%s', $this->getEmailSlug(), $this->getTemplateSlug(), 'subject'),
            $this->customSubjectParameters(),
            $this->configuration->getTranslationPrefix()
        );
    }

    /** @return array<string, mixed> */
    protected function customSubjectParameters(): array
    {
        return [];
    }

    protected function getBody(): string
    {
        if (static::BODY_TYPE === static::BODY_TYPE_TRANSLATION) {
            return $this->getTranslationBody();
        }

        if (static::BODY_TYPE === static::BODY_TYPE_TWIG) {
            return $this->getTwigBody();
        }

        return '';
    }

    protected function getTranslationBody(string $templatingFolder = 'emails'): string
    {
        return $this->translator->trans(
            \sprintf('%s.%s.%s', $this->getEmailSlug(), $this->getTemplateSlug(), 'body'),
            $this->customBodyParameters(),
            $this->configuration->getTranslationPrefix()
        );
    }

    protected function getTwigBody(string $templatingFolder = 'emails'): string
    {
        return $this->templating->render(
            \sprintf('%s/%s/%s.html.twig', $templatingFolder, $this->getEmailSlug(), $this->getTemplateSlug()),
            $this->customBodyParameters()
        );
    }

    /** @return array<string, mixed> */
    protected function customBodyParameters(): array
    {
        return [];
    }

    final protected function getEmail(): ?Email
    {
        $template = $this->getTemplateSlug();

        if (!$this->supportTemplate($template)) {
            throw new InvalidEmailServiceException($this::class, $template);
        }

        $this->assertValidParameters();
        $to = $this->getTo();

        if (empty($to)) {
            return null;
        }

        $email = new Email();
        $email->subject($this->getSubject())
            ->html($this->getBody())
            ->to(...$to);

        if (!empty($this->getCc())) {
            $email->cc(...$this->getCc());
        }

        if (!empty($this->getFrom())) {
            $email->from(...$this->getFrom());
        }

        foreach ($this->getAttachments() as $attachment) {
            if ($attachment instanceof Attachment) {
                $email->attach($attachment->getData(), $attachment->getFilename(), $attachment->getContentType());
            }
        }

        return $email;
    }

    final public function send(): void
    {
        $email = $this->getEmail();

        if ($email === null) {
            return;
        }

        $this->mailer->send($email);
    }

    final public function supportTemplate(string $template): bool
    {
        return \in_array($template, static::TEMPLATES);
    }

    final protected function getTemplateSlug(): string
    {
        return ($this->emailTemplateFetcher)($this->getEmailSlug());
    }
}
