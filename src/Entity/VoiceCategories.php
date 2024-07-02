<?php

namespace App\Entity;

use App\Repository\VoiceCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoiceCategoriesRepository::class)]
class VoiceCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    /**
     * @var Collection<int, Horair>
     */
    #[ORM\OneToMany(targetEntity: Horair::class, mappedBy: 'version')]
    private Collection $horairs;

    public function __construct()
    {
        $this->horairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $horair->setVersion($this);
        }

        return $this;
    }

    public function removeHorair(Horair $horair): static
    {
        if ($this->horairs->removeElement($horair)) {
            // set the owning side to null (unless already changed)
            if ($horair->getVersion() === $this) {
                $horair->setVersion(null);
            }
        }

        return $this;
    }
}
