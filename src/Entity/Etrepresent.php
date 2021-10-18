<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtrepresentRepository")
 */
class Etrepresent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datepresence;

    /**
     * @ORM\Column(type="time")
     */
    private $heuredebut;

    /**
     * @ORM\Column(type="time")
     */
    private $heurefin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="etrepresents")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="etrepresents")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getDatepresence(): ?\DateTimeInterface
    {
        return $this->datepresence;
    }

    public function setDatepresence(\DateTimeInterface $datepresence): self
    {
        $this->datepresence = $datepresence;

        return $this;
    }

    public function getHeuredebut(): ?\DateTimeInterface
    {
        return $this->heuredebut;
    }

    public function setHeuredebut(\DateTimeInterface $heuredebut): self
    {
        $this->heuredebut = $heuredebut;

        return $this;
    }

    public function getHeurefin(): ?\DateTimeInterface
    {
        return $this->heurefin;
    }

    public function setHeurefin(\DateTimeInterface $heurefin): self
    {
        $this->heurefin = $heurefin;

        return $this;
    }

    public function getRestaurant(): ?restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
