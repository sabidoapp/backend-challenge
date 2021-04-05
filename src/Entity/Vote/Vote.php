<?php

declare(strict_types=1);

namespace App\Entity\Vote;

use App\AccessPropertyTrait;
use App\AuthorshipTrait;
use App\Entity\Category\Category;
use App\Entity\Indicated\Indicated;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vote entity.
 *
 * @property int       $id
 * @property Category  $category
 * @property Indicated $indicated
 * @property int       $rating
 *
 * @ORM\Table(
 *     name="vote",
 *     options={
 *         "collate": "utf8_general_ci",
 *         "charset": "utf8",
 *         "engine": "InnoDB"
 *     },
 *     indexes={
 *         @ORM\Index(name="vote_rating", columns={"rating"}),
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\Vote\VoteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Vote
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
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Category\Category",
     *     cascade={"persist", "refresh"},
     *     inversedBy="votes",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinColumn(
     *     name="category_id",
     *     referencedColumnName="id",
     *     nullable=false,
     *     onDelete="cascade"
     * )
     */
    private Category $category;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.indicated")
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Indicated\Indicated",
     *     cascade={"persist", "refresh"},
     *     inversedBy="votes",
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinColumn(
     *     name="indicated_id",
     *     referencedColumnName="id",
     *     nullable=false,
     *     onDelete="cascade"
     * )
     */
    private Indicated $indicated;

    /**
     * @Groups({"show", "list"})
     *
     * @Assert\NotBlank(message="model.not_blank.rating")
     * @ORM\Column(type="integer")
     */
    private int $rating = 0;
}
