<?php

namespace App\Entity;

use App\Repository\ErgonomyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ErgonomyRepository::class)
 */
class Ergonomy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Hall::class, mappedBy="ergonomy")
     */
    private $halls;

    public function __construct()
    {
        $this->halls = new ArrayCollection();
    }
    /**
     * Here the _tostring() allows a class to decide how it will react when it is treated like a string
     */
    public function __toString() {
        return $this->name;
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

    /**
     * @return Collection|Hall[]
     */
    public function getHalls(): Collection
    {
        return $this->halls;
    }

    public function addHall(Hall $hall): self
    {
        if (!$this->halls->contains($hall)) {
            $this->halls[] = $hall;
            $hall->addErgonomy($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): self
    {
        if ($this->halls->removeElement($hall)) {
            $hall->removeErgonomy($this);
        }

        return $this;
    }
}
