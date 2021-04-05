<?php

declare(strict_types=1);

namespace App\DataFixtures\Indicated;

use App\Entity\Indicated\Indicated;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Indicated Fixtures.
 */
class InidicatedFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    public array $indicated = [
        'Alfa Mist' => 'BMUS',
        'Notorius BIG' => 'BMUS',
        'Kendrick Lamar' => 'BMUS',
        'Denzel Washington' => 'BINT',
    ];

    /**
     * Load fixtures.
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->indicated as $name => $category) {
            $indicated = new Indicated();
            $indicated->name = $name;
            $indicated->addCategories(
                /* @phpstan-ignore-next-line */
                $this->getReference(
                    sprintf('category-%s', strtolower($category))
                )
            );
            $manager->persist($indicated);

            $this->addReference(
                sprintf('indicated-%s-%s', str_replace(' ', '-', strtolower($name)), strtolower($category)),
                $indicated
            );
        }

        $manager->flush();
        $manager->clear();
    }

    /**
     * Get order number.
     */
    public function getOrder(): int
    {
        return 1;
    }
}
