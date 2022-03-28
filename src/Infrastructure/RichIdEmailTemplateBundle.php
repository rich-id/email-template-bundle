<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;

class RichIdEmailTemplateBundle extends AbstractBundle
{
    /** @var array<string, string> */
    protected static $doctrineAttributeMapping = [
        'RichId\\EmailTemplateBundle\\Domain\\Entity' => __DIR__ . '/../Domain/Entity',
    ];
}
