<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_figures")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This Trick already exist"
 * )
 */
class Figure
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Comment[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="App\Entity\Comment",
     *      mappedBy="figure",
     *      fetch="EXTRA_LAZY",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     * @ORM\OrderBy({"createdAt": "DESC"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="app_figures_categories")
     * @Assert\Count(
     *      min = 1,
     *      max = 3,
     *      minMessage = "You must choose at least one category",
     *      maxMessage = "You cannot choose more than {{ limit }} category"
     * )
     */
    private $categories;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Image",
     *     mappedBy="figure",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Video",
     *     mappedBy="figure",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    private $videos;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        $this->setSlug($this->name);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * @param $text
     * @return null|string|string[]
     */
    function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(?Comment $comment): void
    {
        $comment->setFigure($this);
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment): void
    {
        $comment->setFigure(null);
        $this->comments->removeElement($comment);
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFigure($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getFigure() === $this) {
                $image->setFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setFigure($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getFigure() === $this) {
                $video->setFigure(null);
            }
        }

        return $this;
    }

}
