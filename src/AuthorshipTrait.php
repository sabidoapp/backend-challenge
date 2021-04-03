<?php

declare(strict_types=1);

namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * Authorship trait.
 *
 * @ORM\HasLifecycleCallbacks
 */
trait AuthorshipTrait
{
    /**
     * @Groups({"system"})
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected \DateTime $createdAt;

    /**
     * @Groups({"system"})
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected \DateTime $updatedAt;

    /**
     * Update fields by persistence type.
     *
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Update fields by persistence type.
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
