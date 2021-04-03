<?php

declare(strict_types=1);

namespace App\Repository\Category;

use App\Entity\Category\Category;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Category entity repository.
 *
 * {@inheritdoc}
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * Constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
