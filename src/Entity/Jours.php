<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JoursRepository")
 */
class Jours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ouvrir", mappedBy="id_jour")
     */
    private $collouvrir;

    public function __construct()
    {
        $this->collouvrir = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * @return Collection|Ouvrir[]
     */
    public function getCollouvrir(): Collection
    {
        return $this->collouvrir;
    }

    public function addCollouvrir(Ouvrir $collouvrir): self
    {
        if (!$this->collouvrir->contains($collouvrir)) {
            $this->collouvrir[] = $collouvrir;
            $collouvrir->setIdJour($this);
        }

        return $this;
    }

    public function removeCollouvrir(Ouvrir $collouvrir): self
    {
        if ($this->collouvrir->contains($collouvrir)) {
            $this->collouvrir->removeElement($collouvrir);
            // set the owning side to null (unless already changed)
            if ($collouvrir->getIdJour() === $this) {
                $collouvrir->setIdJour(null);
            }
        }

        return $this;
    }
}
