<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'film', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'films')]
    private Collection $categories;

    /**
     * @var Collection<int, Horair>
     */
    #[ORM\OneToMany(targetEntity: Horair::class, mappedBy: 'film', orphanRemoval: true)]
    private Collection $horairs;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->horairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Horair>
     */
    public function getHorairs(): Collection
    {
        return $this->horairs;
    }

    public function addHorair(Horair $horair): static
    {
        if (!$this->horairs->contains($horair)) {
            $this->horairs->add($horair);
            $horair->setFilm($this);
        }

        return $this;
    }

    public function removeHorair(Horair $horair): static
    {
        if ($this->horairs->removeElement($horair)) {
            // set the owning side to null (unless already changed)
            if ($horair->getFilm() === $this) {
                $horair->setFilm(null);
            }
        }

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
