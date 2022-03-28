<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Adapter;

use RichId\EmailTemplateBundle\Domain\Port\TemplatingInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment;

class TemplatingAdapter implements TemplatingInterface
{
    #[Required]
    public Environment $twig;

    /** @param array<string, string> $context */
    public function render(string $name, array $context = []): string
    {
        return $this->twig->render($name, $context);
    }
}
