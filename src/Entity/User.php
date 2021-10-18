<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Identifiant déjà pris")
 */
class User implements UserInterface
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath="confirmpassword",message="Le mot de passe est different")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="confirmpassword",message="Le mot de passe est different")
     * @Assert\EqualTo(propertyPath="confirmpassword")
     */
    public $confirmpassword;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Etrepresent", mappedBy="user") 
     */
    private $etrepresents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $lieux;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\Column(type="boolean")
     */
    private $nepasderanger;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer_stripe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_debut_abonnement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codepromo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Photoprofil", cascade={"persist", "remove"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="users")
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    public function __construct()
    {
        $this->etrepresents = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

  
    public function getSalt()
    {
         
    }

     
    public function eraseCredentials()
    {
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
            $etrepresent->setUser($this);
        }

        return $this;
    }

    public function removeEtrepresent(Etrepresent $etrepresent): self
    {
        if ($this->etrepresents->contains($etrepresent)) {
            $this->etrepresents->removeElement($etrepresent);
            // set the owning side to null (unless already changed)
            if ($etrepresent->getUser() === $this) {
                $etrepresent->setUser(null);
            }
        }

        return $this;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLieux(): ?int
    {
        return $this->lieux;
    }

    public function setLieux(int $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getNepasderanger(): ?bool
    {
        return $this->nepasderanger;
    }

    public function setNepasderanger(bool $nepasderanger): self
    {
        $this->nepasderanger = $nepasderanger;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getCustomerStripe(): ?string
    {
        return $this->customer_stripe;
    }

    public function setCustomerStripe(string $customer_stripe): self
    {
        $this->customer_stripe = $customer_stripe;

        return $this;
    }

    public function getDateDebutAbonnement(): ?\DateTimeInterface
    {
        return $this->date_debut_abonnement;
    }

    public function setDateDebutAbonnement(?\DateTimeInterface $date_debut_abonnement): self
    {
        $this->date_debut_abonnement = $date_debut_abonnement;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

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

    public function getCodepromo(): ?string
    {
        return $this->codepromo;
    }

    public function setCodepromo(?string $codepromo): self
    {
        $this->codepromo = $codepromo;

        return $this;
    }

    public function getPhoto(): ?Photoprofil
    {
        return $this->photo;
    }

    public function setPhoto(?Photoprofil $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

}
