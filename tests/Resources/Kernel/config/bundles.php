<?php

declare(strict_types=1);

return [
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class                            => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                                             => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class                    => ['all' => true],
    RichCongress\RecurrentFixturesTestBundle\RichCongressRecurrentFixturesTestBundle::class => ['all' => true],
    RichId\EmailTemplateBundle\Infrastructure\RichIdEmailTemplateBundle::class              => ['all' => true],
];
