<?php

namespace App\Entity;

use App\Repository\DdressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DdressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $addressLine = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $country = null;

    /**
     * @var Collection<int, PayMEthode>
     */
    #[ORM\OneToMany(targetEntity: PayMEthode::class, mappedBy: 'address')]
    private Collection $payMEthodes;

    public function __construct()
    {
        $this->payMEthodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressLine(): ?string
    {
        return $this->addressLine;
    }

    public function setAddressLine(string $addressLine): static
    {
        $this->addressLine = $addressLine;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, PayMEthode>
     */
    public function getPayMEthodes(): Collection
    {
        return $this->payMEthodes;
    }

    public function addPayMEthode(PayMEthode $payMEthode): static
    {
        if (!$this->payMEthodes->contains($payMEthode)) {
            $this->payMEthodes->add($payMEthode);
            $payMEthode->setAddress($this);
        }

        return $this;
    }

    public function removePayMEthode(PayMEthode $payMEthode): static
    {
        if ($this->payMEthodes->removeElement($payMEthode)) {
            // set the owning side to null (unless already changed)
            if ($payMEthode->getAddress() === $this) {
                $payMEthode->setAddress(null);
            }
        }

        return $this;
    }
}
