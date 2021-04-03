<?php

declare(strict_types=1);

namespace App\Repository\Indicated;

use App\Entity\Indicated\Indicated;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Indicated entity repository.
 *
 * {@inheritdoc}
 */
class IndicatedRepository extends AbstractRepository
{
    /**
     * Constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indicated::class);
    }
}
