<?php

declare(strict_types=1);

namespace App\DataFixtures\Category;

use App\Entity\Category\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Category Fixtures.
 */
class CategoryFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    private array $categories = [
        'Best music' => 'BMUS',
        'Best Photography' => 'BPHO',
        'Best interpretation' => 'BINT',
    ];

    /**
     * Load fixtures.
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $name => $abrev) {
            $category = new Category();
            $category->name = $name;
            $category->abrev = $abrev;
            $manager->persist($category);

            $this->addReference(sprintf('category-%s', strtolower($abrev)), $category);
        }

        $manager->flush();
        $manager->clear();
    }

    /**
     * Get order number.
     */
    public function getOrder(): int
    {
        return 0;
    }
}
