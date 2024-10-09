<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HallRepository::class)
 */
class Hall
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
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\ManyToMany(targetEntity=Ergonomy::class, inversedBy="halls")
     */
    private $ergonomy;

    /**
     * @ORM\ManyToMany(targetEntity=Material::class, inversedBy="halls")
     */
    private $material;

    /**
     * @ORM\ManyToMany(targetEntity=Software::class, inversedBy="halls")
     */
    private $software;

    /**
     * @ORM\ManyToOne(targetEntity=Arrangement::class, inversedBy="halls")
     */
    private $arrangement;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="hall")
     */
    private $reservation;

    public function __construct()
    {
        $this->ergonomy = new ArrayCollection();
        $this->material = new ArrayCollection();
        $this->software = new ArrayCollection();
        $this->reservation = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection|Ergonomy[]
     */
    public function getErgonomy(): Collection
    {
        return $this->ergonomy;
    }

    public function addErgonomy(Ergonomy $ergonomy): self
    {
        if (!$this->ergonomy->contains($ergonomy)) {
            $this->ergonomy[] = $ergonomy;
        }

        return $this;
    }

    public function removeErgonomy(Ergonomy $ergonomy): self
    {
        $this->ergonomy->removeElement($ergonomy);

        return $this;
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material[] = $material;
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        $this->material->removeElement($material);

        return $this;
    }

    /**
     * @return Collection|Software[]
     */
    public function getSoftware(): Collection
    {
        return $this->software;
    }

    public function addSoftware(Software $software): self
    {
        if (!$this->software->contains($software)) {
            $this->software[] = $software;
        }

        return $this;
    }

    public function removeSoftware(Software $software): self
    {
        $this->software->removeElement($software);

        return $this;
    }

    public function getArrangement(): ?Arrangement
    {
        return $this->arrangement;
    }

    public function setArrangement(?Arrangement $arrangement): self
    {
        $this->arrangement = $arrangement;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setHall($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHall() === $this) {
                $reservation->setHall(null);
            }
        }

        return $this;
    }
}
