<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OuvrirRepository")
 */
class Ouvrir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_debut;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_fin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ouvert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="collouvrir")
     */
    private $id_restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jours", inversedBy="collouvrir")
     */
    private $id_jour;

    public function getId()
    {
        return $this->id;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getOuvert(): ?bool
    {
        return $this->ouvert;
    }

    public function setOuvert(bool $ouvert): self
    {
        $this->ouvert = $ouvert;

        return $this;
    }

    public function getIdRestaurant(): ?Restaurant
    {
        return $this->id_restaurant;
    }

    public function setIdRestaurant(?Restaurant $id_restaurant): self
    {
        $this->id_restaurant = $id_restaurant;

        return $this;
    }

    public function getIdJour(): ?Jours
    {
        return $this->id_jour;
    }

    public function setIdJour(?Jours $id_jour): self
    {
        $this->id_jour = $id_jour;

        return $this;
    }
}
