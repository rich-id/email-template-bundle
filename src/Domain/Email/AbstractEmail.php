<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Email;

use RichId\EmailTemplateBundle\Domain\Attachment\Attachment;
use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Exception\InvalidEmailServiceException;
use RichId\EmailTemplateBundle\Domain\Fetcher\EmailTemplateFetcher;
use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;
use RichId\EmailTemplateBundle\Domain\Port\TemplatingInterface;
use RichId\EmailTemplateBundle\Domain\Port\TranslatorInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

/** @template T of EmailModelInterface */
abstract class AbstractEmail
{
    public const TEMPLATES = [Constant::DEFAULT_TEMPLATE];
    public const EMAIL_SLUG_HEADER = 'abstract-email-slug';

    protected const BODY_TYPE = self::BODY_TYPE_TRANSLATION;

    protected const BODY_TYPE_TRANSLATION = 'translation';
    protected const BODY_TYPE_TWIG = 'twig';

    protected const TRANSLATION_DOMAIN = 'emails';
    protected const TEMPLATING_FOLDER = 'emails';

    protected const EMAIL_CLASS = Email::class;

    #[Required]
    public TemplatingInterface $templating;

    #[Required]
    public TranslatorInterface $translator;

    #[Required]
    public EmailTemplateFetcher $emailTemplateFetcher;

    /** @var ?T */
    protected ?EmailModelInterface $data = null;

    /**
     * @param ?T $data
     *
     * @return AbstractEmail<T>
     */
    public function setData(?EmailModelInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

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
            static::TRANSLATION_DOMAIN
        );
    }

    public function canSeeEmailInAdministration(): bool
    {
        return true;
    }

    /** @return string[] */
    protected function getCc(): array
    {
        return [];
    }

    /** @return string[] */
    protected function getBcc(): array
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

    protected function skippedIf(): bool
    {
        return false;
    }

    protected function getSubject(): string
    {
        return $this->translator->trans(
            \sprintf('%s.%s.%s', $this->getEmailSlug(), $this->getTemplateSlug(), 'subject'),
            $this->customSubjectParameters(),
            static::TRANSLATION_DOMAIN
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

        throw new \InvalidArgumentException(\sprintf('Invalid argument for BODY_TYPE: %s given.', static::BODY_TYPE));
    }

    protected function getTranslationBody(): string
    {
        return $this->translator->trans(
            \sprintf('%s.%s.%s', $this->getEmailSlug(), $this->getTemplateSlug(), 'body'),
            $this->customBodyParameters(),
            static::TRANSLATION_DOMAIN
        );
    }

    protected function getTwigBody(): string
    {
        return $this->templating->render(
            \sprintf('%s/%s/%s.html.twig', static::TEMPLATING_FOLDER, $this->getEmailSlug(), $this->getTemplateSlug()),
            $this->customBodyParameters()
        );
    }

    /** @return array<string, mixed> */
    protected function customBodyParameters(): array
    {
        return [];
    }

    protected function emailUpdater(Email $email): void
    {
    }

    final protected function getEmail(): ?Email
    {
        $template = $this->getTemplateSlug();

        if (!$this->supportTemplate($template)) {
            throw new InvalidEmailServiceException($this::class, $template);
        }

        $this->assertValidParameters();

        if ($this->skippedIf()) {
            return null;
        }

        $to = $this->getTo();

        if (empty($to)) {
            return null;
        }

        /** @var Email $email */
        $email = new (static::EMAIL_CLASS)();
        $email->subject($this->getSubject())
            ->html($this->getBody())
            ->to(...\array_unique($to));

        $email->getHeaders()->addTextHeader(self::EMAIL_SLUG_HEADER, $this->getEmailSlug());

        if (!empty($this->getCc())) {
            $email->cc(...\array_unique($this->getCc()));
        }

        if (!empty($this->getBcc())) {
            $email->bcc(...\array_unique($this->getBcc()));
        }

        if (!empty($this->getFrom())) {
            $email->from(...\array_unique($this->getFrom()));
        }

        foreach ($this->getAttachments() as $attachment) {
            if ($attachment instanceof Attachment) {
                $email->attach($attachment->getData(), $attachment->getFilename(), $attachment->getContentType());
            }
        }

        $this->emailUpdater($email);

        return $email;
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
