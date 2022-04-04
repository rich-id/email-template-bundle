<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\EmailTemplateBundle\Infrastructure\Repository\EmailTemplateConfigurationRepository;

#[ORM\Entity(repositoryClass: EmailTemplateConfigurationRepository::class)]
#[ORM\Table(name: 'module_email_template_configuration')]
class EmailTemplateConfiguration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'slug', type: 'string', unique: true)]
    private string $slug;

    #[ORM\Column(name: 'value', type: 'string')]
    private string $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
