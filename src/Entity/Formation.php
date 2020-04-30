<?php
 
 namespace App\Entity;
  
 use Doctrine\Common\Collections\ArrayCollection;
 use Doctrine\Common\Collections\Collection;
 use Doctrine\ORM\Mapping as ORM;
  
 /**
  * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
  */
 class Formation
 {
     /**
      * @ORM\Id()
      * @ORM\GeneratedValue()
      * @ORM\Column(type="integer")
      */
     private $id;
  
     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Produit")
      * @ORM\JoinColumn(nullable=true)
      */
     private $Produit;
     /**
      * @ORM\Column(type="date")
      */
     private $dateDebut;
  
     /**
      * @ORM\Column(type="integer")
      */
     private $nbreHeures;
  
     /**
      * @ORM\Column(type="integer")
      */
     private $departement;
  
     /**
      * @ORM\Column(type="string", length=20)
      */
     private $ville;
  
     public function __construct()
     {
         $this->formation = new ArrayCollection();
     }
         public function getId(): ?int
     {
         return $this->id;
     }

     public function __toString()
    {
        return (string) $this->id;
    } 
  
     public function getDateDebut(): ?\DateTimeInterface
     {
         return $this->dateDebut;
     }
  
     public function setDateDebut(\DateTimeInterface $dateDebut): self
     {
         $this->dateDebut = $dateDebut;
  
         return $this;
     }
  
     public function getNbreHeures(): ?int
     {
         return $this->nbreHeures;
     }
  
     public function setNbreHeures(int $nbreHeures): self
     {
         $this->nbreHeures = $nbreHeures;
  
         return $this;
     }
  
     public function getDepartement(): ?int
     {
         return $this->departement;
     }
  
     public function setDepartement(int $departement): self
     {
         $this->departement = $departement;
  
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
  
     public function getProduit(): ?Produit
     {
         return $this->Produit;
     }
  
     public function setProduit(Produit $Produit):self
     {
         $this->Produit = $Produit;
  
         return $this;
     }
  
     /**
      * @return Collection|Inscription[]
      */
     public function getFormation(): Collection
     {
         return $this->formation;
     }
  
     public function addFormation(Inscription $formation): self
     {
         if (!$this->formation->contains($formation)) {
             $this->formation[] = $formation;
             $formation->addFormation($this);
         }
  
         return $this;
     }
  
     public function removeFormation(Inscription $formation): self
     {
         if ($this->formation->contains($formation)) {
             $this->formation->removeElement($formation);
             $formation->removeFormation($this);
         }
  
         return $this;
     }
  
 }

  
   
