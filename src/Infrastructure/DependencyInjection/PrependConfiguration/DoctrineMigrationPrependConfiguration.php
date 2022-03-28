<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\DependencyInjection\PrependConfiguration;

use RichCongress\BundleToolbox\Configuration\PrependConfiguration\AbstractDoctrineMigrationPrependConfiguration;

final class DoctrineMigrationPrependConfiguration extends AbstractDoctrineMigrationPrependConfiguration
{
    /** @return array<string, string> */
    protected function getBindings(): array
    {
        return [
            'RichId\EmailTemplateBundle\Infrastructure\Migrations' => __DIR__ . '/../../Migrations',
        ];
    }
}
