<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use RichId\EmailTemplateBundle\Domain\Constant;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_email_template';

    public const TRANSLATION_DOMAIN = 'translation_domain';

    protected function buildConfig(NodeBuilder $rootNode): void
    {
        $this->translationDomain($rootNode);
    }

    protected function translationDomain(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->scalarNode(self::TRANSLATION_DOMAIN)
            ->defaultValue(Constant::DEFAULT_TRANSLATION_DOMAIN);
    }
}
