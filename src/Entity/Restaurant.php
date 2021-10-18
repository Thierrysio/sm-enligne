<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
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
    private $raisonsociale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="text")
     */
    private $infos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ouvrir", mappedBy="id_restaurant")
     */
    private $collouvrir;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Description", mappedBy="restaurant")
     */
    private $colldescription;

    /**
     * @ORM\Column(type="text")
     */
    private $avantages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etrepresent", mappedBy="restaurant")
     */
    private $etrepresents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categories", inversedBy="restaurants")
     */
    private $categorie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    

    public function __construct()
    {
        $this->ouvrirs = new ArrayCollection();
        $this->collouvrir = new ArrayCollection();
        $this->collavantages = new ArrayCollection();
        $this->colldescription = new ArrayCollection();
        $this->etrepresents = new ArrayCollection();
        $this->categorie = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRaisonsociale(): ?string
    {
        return $this->raisonsociale;
    }

    public function setRaisonsociale(string $raisonsociale): self
    {
        $this->raisonsociale = $raisonsociale;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
            $collouvrir->setIdRestaurant($this);
        }

        return $this;
    }

    public function removeCollouvrir(Ouvrir $collouvrir): self
    {
        if ($this->collouvrir->contains($collouvrir)) {
            $this->collouvrir->removeElement($collouvrir);
            // set the owning side to null (unless already changed)
            if ($collouvrir->getIdRestaurant() === $this) {
                $collouvrir->setIdRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Description[]
     */
    public function getColldescription(): Collection
    {
        return $this->colldescription;
    }

    public function addColldescription(Description $colldescription): self
    {
        if (!$this->colldescription->contains($colldescription)) {
            $this->colldescription[] = $colldescription;
            $colldescription->setRestaurant($this);
        }

        return $this;
    }

    public function removeColldescription(Description $colldescription): self
    {
        if ($this->colldescription->contains($colldescription)) {
            $this->colldescription->removeElement($colldescription);
            // set the owning side to null (unless already changed)
            if ($colldescription->getRestaurant() === $this) {
                $colldescription->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getAvantages(): ?string
    {
        return $this->avantages;
    }

    public function setAvantages(string $avantages): self
    {
        $this->avantages = $avantages;

        return $this;
    }

    /**
     * @return Collection|Etrepresent[]
     */
    public function getEtrepresents(): Collection
    {
        return $this->etrepresents;
    }

    public function addEtrepresent(Etrepresent $etrepresent): self
    {
        if (!$this->etrepresents->contains($etrepresent)) {
            $this->etrepresents[] = $etrepresent;
            $etrepresent->setRestaurant($this);
        }

        return $this;
    }

    public function removeEtrepresent(Etrepresent $etrepresent): self
    {
        if ($this->etrepresents->contains($etrepresent)) {
            $this->etrepresents->removeElement($etrepresent);
            // set the owning side to null (unless already changed)
            if ($etrepresent->getRestaurant() === $this) {
                $etrepresent->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categories $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categories $categorie): self
    {
        if ($this->categorie->contains($categorie)) {
            $this->categorie->removeElement($categorie);
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

     

    
}
