<?php
 
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;    
/**
 * @ORM\Entity(repositoryClass="App\Repository\VisiteurRepository")
 */
class Visiteur 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $login;
 
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $mdp;
 
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;
 
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;
 
    public function __construct()
    {
        $this->visiteur = new ArrayCollection();
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getLogin(): ?string
    {
        return $this->login;
    }
 
    public function setLogin(string $login): self
    {
        $this->login = $login;
 
        return $this;
    }
 
    public function getMdp(): ?string
    {
        return $this->mdp;
    }
 
    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;
 
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
 
    /**
     * @return Collection|Inscription[]
     */
    public function getVisiteur(): Collection
    {
        return $this->visiteur;
    }
 
    public function addVisiteur(Inscription $visiteur): self
    {
        if (!$this->Visiteur->contains($visiteur)) {
            $this->Visiteur[] = $visiteur;
            $visiteur->addInscription($this);
        }
 
        return $this;
    }
 
    public function removeVisiteur(Inscription $visiteur): self
    {
        if ($this->Visiteur->contains($visiteur)) {
            $this->Visiteur->removeElement($visiteur);
            $visiteur->removeInscription($this);
        }
 
        return $this;
    }
 
    public function setVisiteur(?Inscription $visiteur): self
    {
        $this->visiteur = $visiteur;
 
        return $this;
    }
 
}