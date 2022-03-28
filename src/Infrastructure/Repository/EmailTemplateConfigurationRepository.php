<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RichId\EmailTemplateBundle\Domain\Entity\EmailTemplateConfiguration;

/**
 * @extends ServiceEntityRepository<EmailTemplateConfiguration>
 *
 * @method EmailTemplateConfiguration findOneBySlug(string $slug)
 */
class EmailTemplateConfigurationRepository extends ServiceEntityRepository
{
    /** @codeCoverageIgnore  */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailTemplateConfiguration::class);
    }
}
