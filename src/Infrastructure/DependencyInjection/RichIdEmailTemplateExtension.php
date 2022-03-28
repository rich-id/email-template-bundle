<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractExtension;
use RichId\EmailTemplateBundle\Domain\Email\AbstractEmail;
use RichId\EmailTemplateBundle\Infrastructure\DependencyInjection\CompilerPass\EmailsCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RichIdEmailTemplateExtension extends AbstractExtension implements PrependExtensionInterface
{
    /** @param array<string, mixed> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->parseConfiguration(
            $container,
            new Configuration(),
            $configs
        );

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->registerForAutoconfiguration(AbstractEmail::class)->addTag(EmailsCompilerPass::TAG);
    }
}
