<?php

declare(strict_types=1);

namespace App\Entity\Category;

use App\AccessPropertyTrait;
use App\AuthorshipTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category entity.
 *
 * @property int        $id
 * @property Collection $votes
 * @property Collection $nominated
 * @property string     $name
 * @property string     $abrev
 *
 * @ORM\Table(
 *     name="category",
 *     options={
 *         "collate": "utf8_general_ci",
 *         "charset": "utf8",
 *         "engine": "InnoDB"
 *     },
 *     indexes={
 *         @ORM\Index(name="category_name", columns={"name"}),
 *         @ORM\Index(name="category_abrev", columns={"abrev"}),
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\Category\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category
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
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Vote\Vote",
     *     cascade={"persist", "refresh"},
     *     mappedBy="category",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\OrderBy({"id": "desc"})
     */
    private Collection $votes;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Indicated\Indicated",
     *     cascade={"persist", "refresh"},
     *     mappedBy="categories",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\OrderBy({"id": "desc"})
     */
    private Collection $indicated;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.name")
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private string $name;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.abrev")
     * @ORM\Column(type="string", length=5, unique=true)
     */
    private string $abrev;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    /**
     * String.
     */
    public function __toString(): string
    {
        return strtoupper($this->abrev);
    }

    /**
     * @Groups({"stats"})
     */
    public function getCountNominated(): int
    {
        if (empty($this->nominated)) {
            return 0;
        }

        return $this->nominated->count();
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
}
