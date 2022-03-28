<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Adapter;

use RichId\EmailTemplateBundle\Domain\Constant;
use RichId\EmailTemplateBundle\Domain\Port\ConfigurationInterface;
use RichId\EmailTemplateBundle\Infrastructure\DependencyInjection\Configuration as BundleConfiguration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ConfigurationAdapter implements ConfigurationInterface
{
    #[Required]
    public ParameterBagInterface $parameterBag;

    public function getTranslationPrefix(): string
    {
        return (string) $this->parameterBag->get(BundleConfiguration::getKey(BundleConfiguration::TRANSLATION_DOMAIN)) ?? Constant::DEFAULT_TRANSLATION_DOMAIN;
    }
}
