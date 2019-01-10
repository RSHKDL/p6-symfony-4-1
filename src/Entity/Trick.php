<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_tricks")
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This Trick already exist"
 * )
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="tricks"
     * )
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $author;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Category",
     *     cascade={"persist"}
     * )
     * @ORM\JoinTable(name="app_tricks_categories")
     * @Assert\Count(
     *      min = 1,
     *      max = 3,
     *      minMessage = "You must choose at least one category",
     *      maxMessage = "You cannot choose more than {{ limit }} category"
     * )
     */
    private $categories;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Image",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @ORM\JoinColumn()
     * @var Image
     */
    private $imageFeatured;

    /**
     * @var \ArrayAccess
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Image",
     *     fetch="EXTRA_LAZY",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @ORM\JoinTable(
     *     name="app_tricks_images",
     *     joinColumns={@ORM\JoinColumn(name="trick_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")}
     * )
     * @Assert\Valid()
     */
    private $images;

    /**
     * @var \ArrayAccess
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Video",
     *     mappedBy="trick",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    private $videos;

    /**
     * @var Comment[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="App\Entity\Comment",
     *      mappedBy="trick",
     *      fetch="EXTRA_LAZY",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     * @ORM\OrderBy({"createdAt": "DESC"})
     */
    private $comments;

    /**
     * Trick constructor.
     * @param string $name
     * @param string $description
     * @param User|null $author
     * @param Image|null $imageFeatured
     * @param array $images
     * @param array $videos
     * @param ArrayCollection|null $categories
     */
    public function __construct(
        string $name,
        string $description,
        ?User $author,
        ?Image $imageFeatured,
        array $images = [],
        array $videos = [],
        ?ArrayCollection $categories
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = new \DateTime();
        $this->author = $author;
        $this->categories = new ArrayCollection();
        $this->imageFeatured = $imageFeatured;
        $this->images = new ArrayCollection($images);
        $this->videos = new ArrayCollection($videos);
        $this->comments = new ArrayCollection();

        if ($categories) {
            foreach ($categories as $category) {
                $this->addCategory($category);
            }
        }

        foreach ($videos as $video) {
            $video->setTrick($this);
        }
    }

    /**
     * @param string $name
     * @param string $description
     * @param Image|null $imageFeatured
     * @param array|null $images
     * @param array|null $videos
     * @param array $categories
     */
    public function update(
        string $name,
        string $description,
        ?Image $imageFeatured,
        array $images = null,
        array $videos = null,
        array $categories
    ): void {
        $this->name = $name;
        $this->description = $description;
        $this->updateDate();
        $this->updateCategories($categories);
        $this->imageFeatured = $imageFeatured;
        $this->updateImages($images);
        $this->updateVideos($videos);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return null|Image
     */
    public function getImageFeatured(): ?Image
    {
        return $this->imageFeatured;
    }

    /**
     * @return \ArrayAccess
     */
    public function getImages(): \ArrayAccess
    {
        return $this->images;
    }

    /**
     * @return \ArrayAccess
     */
    public function getVideos(): \ArrayAccess
    {
        return $this->videos;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Trick
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Trick
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     *
     */
    private function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @param array $images
     */
    private function updateImages(array $images)
    {
        $this->getImages()->clear();
        foreach ($images as $image) {
            $this->images->add($image);
        }
    }

    /**
     * @param array $videos
     */
    private function updateVideos(array $videos)
    {
        foreach ($this->videos->getIterator() as $key => $video) {
            if (!array_key_exists($key, $videos)) {
                $video->unsetTrick($this);
                $this->videos->remove($key);
            }
        }
        foreach ($videos as $key => $video){
            $this->videos->set($key, $video);
            $video->setTrick($this);
        }
    }

    /**
     * @param $categories
     */
    private function updateCategories($categories)
    {
        $this->categories->clear();
        foreach ($categories as $category){
            $this->categories->add($category);
        }
    }

    /**
     * @return \ArrayAccess
     */
    public function getComments(): \ArrayAccess
    {
        return $this->comments;
    }

    /**
     * @param Comment|null $comment
     */
    public function addComment(?Comment $comment): void
    {
        $comment->setTrick($this);
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment): void
    {
        $comment->setTrick(null);
        $this->comments->removeElement($comment);
    }

    /**
     * @return \ArrayAccess|Category[]
     */
    public function getCategories(): \ArrayAccess
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return Trick
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    /**
     * @param Category $category
     * @return Trick
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
