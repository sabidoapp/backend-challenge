<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Vote entity repository.
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     */
    public function __construct(ManagerRegistry $registry, string $entity)
    {
        /* @phpstan-ignore-next-line */
        parent::__construct($registry, $entity);
    }
}
