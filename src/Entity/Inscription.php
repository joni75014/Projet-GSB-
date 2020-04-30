<?php
 
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
    * @ORM\ManyToOne(targetEntity="Visiteur",cascade={"persist"})
    * @ORM\JoinColumn()
    */
    private $visiteur;
        /**
    * @ORM\ManyToOne(targetEntity="Formation" )
    * @ORM\JoinColumn()
    */
    private $formation;
    /**
     * @ORM\Column(type="string")
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    } 
    
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getVisiteur(): ?Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteur $visiteur): self
    {
        $this->visiteur = $visiteur;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
   
}