<?php

declare(strict_types=1);

namespace App\Repository\Vote;

use App\Entity\Vote\Vote;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Vote entity repository.
 *
 * {@inheritdoc}
 */
class VoteRepository extends AbstractRepository
{
    /**
     * Constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }
}
