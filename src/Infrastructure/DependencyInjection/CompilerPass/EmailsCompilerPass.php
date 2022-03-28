<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichId\EmailTemplateBundle\Domain\Internal\InternalEmailManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class EmailsCompilerPass extends AbstractCompilerPass
{
    public const TAG = 'email_template.email';

    public function process(ContainerBuilder $container): void
    {
        $references = self::getReferencesByTag($container, self::TAG);
        $definition = $container->getDefinition(InternalEmailManager::class);
        $definition->setProperty('emails', $references);
    }
}
