<?php

declare(strict_types=1);

namespace App\DataFixtures\Vote;

use App\Entity\Vote\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Vote Fixtures.
 */
class VoteFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    /**
     * Load fixtures.
     */
    public function load(ObjectManager $manager): void
    {
        $vote = new Vote();
        /* @phpstan-ignore-next-line */
        $vote->category = $this->getReference(sprintf('category-bmus'));
        /* @phpstan-ignore-next-line */
        $vote->indicated = $this->getReference('indicated-alfa-mist-bmus');
        $vote->rating = 5;
        $manager->persist($vote);

        $manager->flush();
        $manager->clear();
    }

    /**
     * Get order number.
     */
    public function getOrder(): int
    {
        return 10;
    }
}
