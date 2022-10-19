<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolRepository::class)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $villeDepart;

    #[ORM\Column(type: 'string', length: 255)]
    private $villeArrivee;



    #[ORM\Column(type: 'date', nullable:true)]
    private $dateVol;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }



    public function getDateVol(): ?\DateTimeInterface
    {
        return $this->dateVol;
    }

    public function setDateVol(\DateTimeInterface $dateVol): self
    {
        $this->dateVol = $dateVol;

        return $this;
    }

    public function  toArray()
    {
        return [
            'id' => $this.$this->getId(),
             '$villeDepart' => $this->getVilleDepart(),
            '$villeArrivee' => $this->getVilleArrivee(),
            '$dateVol'=>$this->getDateVol()
            ];
    }



}
