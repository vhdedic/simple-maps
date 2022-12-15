<?php

namespace App\Entity;

use App\Repository\NameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NameRepository::class)]
class Name
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $longitude = null;

    #[ORM\Column]
    private ?string $latitude = null;

    #[ORM\OneToMany(targetEntity: NameMap::class, mappedBy: 'name', cascade: ['persist'], orphanRemoval: true)]
    private Collection $name_map;

    public function __construct()
    {
        $this->name_map = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getNameMap()
    {
        return $this->name_map;
    }

    public function __toString() {
        return $this->name;
    }
}
