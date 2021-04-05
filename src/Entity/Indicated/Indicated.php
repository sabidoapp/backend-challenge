<?php

declare(strict_types=1);

namespace App\Entity\Indicated;

use App\AccessPropertyTrait;
use App\AuthorshipTrait;
use App\Entity\Category\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Indicated entity.
 *
 * @property int      $id
 * @property Category $category
 * @property string   $name
 *
 * @ORM\Table(
 *     name="indicated",
 *     options={
 *         "collate": "utf8_general_ci",
 *         "charset": "utf8",
 *         "engine": "InnoDB"
 *     },
 *     indexes={
 *         @ORM\Index(name="indicated_name", columns={"name"}),
 *     }
 * )
 *
 * @UniqueEntity(
 *     fields={"category", "name"},
 *     message="unique.indicated"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\Indicated\IndicatedRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Indicated
{
    use AccessPropertyTrait;
    use AuthorshipTrait;

    /**
     * @Groups({"show", "list"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.category")
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Category\Category",
     *     inversedBy="indicated",
     *     cascade={"persist", "refresh"},
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinTable(name="category_indicated")
     * @MaxDepth(1)
     */
    private Collection $categories;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Vote\Vote",
     *     cascade={"persist", "refresh"},
     *     mappedBy="indicated",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\OrderBy({"id": "desc"})
     */
    private Collection $votes;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.name")
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    /**
     * String.
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @Groups({"stats"})
     */
    public function getCountVotes(): int
    {
        if (empty($this->votes)) {
            return 0;
        }

        return $this->votes->count();
    }

    public function addCategories(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategories(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
