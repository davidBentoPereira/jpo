<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableauRepository")
 */
class Tableau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diplome;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $nbPlaces;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $firstYear;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $secondYear;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diplomeIntermediaire;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $thirdYear;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $poursuiteEtudes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $formationEtConcours;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $vieActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getNbPlaces(): ?string
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(?string $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getFirstYear(): ?string
    {
        return $this->firstYear;
    }

    public function setFirstYear(?string $firstYear): self
    {
        $this->firstYear = $firstYear;

        return $this;
    }

    public function getSecondYear(): ?string
    {
        return $this->secondYear;
    }

    public function setSecondYear(?string $secondYear): self
    {
        $this->secondYear = $secondYear;

        return $this;
    }

    public function getDiplomeIntermediaire(): ?string
    {
        return $this->diplomeIntermediaire;
    }

    public function setDiplomeIntermediaire(?string $diplomeIntermediaire): self
    {
        $this->diplomeIntermediaire = $diplomeIntermediaire;

        return $this;
    }

    public function getThirdYear(): ?string
    {
        return $this->thirdYear;
    }

    public function setThirdYear(?string $thirdYear): self
    {
        $this->thirdYear = $thirdYear;

        return $this;
    }

    public function getPoursuiteEtudes(): ?string
    {
        return $this->poursuiteEtudes;
    }

    public function setPoursuiteEtudes(?string $poursuiteEtudes): self
    {
        $this->poursuiteEtudes = $poursuiteEtudes;

        return $this;
    }

    public function getFormationEtConcours(): ?string
    {
        return $this->formationEtConcours;
    }

    public function setFormationEtConcours(?string $formationEtConcours): self
    {
        $this->formationEtConcours = $formationEtConcours;

        return $this;
    }

    public function getVieActive(): ?string
    {
        return $this->vieActive;
    }

    public function setVieActive(?string $vieActive): self
    {
        $this->vieActive = $vieActive;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
