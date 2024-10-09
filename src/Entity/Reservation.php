<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
 

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{

    public CONST STATUS_ANNULER = "A";
    public CONST STATUS_PENDING = "P";
    public CONST STATUS_VALIDER = "V";

    public CONST STATUS=[
        "Annulé"=>self::STATUS_ANNULER,
        "En Attente"=> self::STATUS_PENDING,
        "Validé"=>self::STATUS_VALIDER,
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enddate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Hall::class, inversedBy="reservation")
     */
    private $hall;

    /**
     * @ORM\ManyToOne(targetEntity=FrontUser::class, inversedBy="reservation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frontUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    public function getFrontUser(): ?FrontUser
    {
        return $this->frontUser;
    }

    public function setFrontUser(?FrontUser $frontUser): self
    {
        $this->frontUser = $frontUser;

        return $this;
    }
}
