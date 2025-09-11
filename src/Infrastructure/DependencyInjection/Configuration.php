<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_email_template';

    protected function buildConfig(NodeBuilder $nodeBuilder): void
    {
        $this->addIgnoredWords($nodeBuilder);
    }

    protected function addIgnoredWords(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->arrayNode('ignored_words')
            ->example(['My word'])
            ->scalarPrototype();
    }
}
