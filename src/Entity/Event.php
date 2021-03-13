<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
    private $title;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $dateOfOpening;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $dateOfClosure;

    /**
     * @ORM\OneToMany(targetEntity="Survey", mappedBy="event", cascade={"persist", "remove"})
     */
    private $surveys;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $description;

    public function __construct(
        string $title,
        \DateTimeImmutable $dateOfOpening,
        \DateTimeImmutable $dateOfClosure
    )
    {
        $this->title = $title;
        $this->dateOfOpening = $dateOfOpening;
        $this->dateOfClosure = $dateOfClosure;
        $this->surveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateOfOpening(): ?\DateTimeInterface
    {
        return $this->dateOfOpening;
    }

    public function setDateOfOpening(\DateTimeInterface $dateOfOpening): self
    {
        $this->dateOfOpening = $dateOfOpening;

        return $this;
    }

    public function getDateOfClosure(): ?\DateTimeInterface
    {
        return $this->dateOfClosure;
    }

    public function setDateOfClosure(\DateTimeInterface $dateOfClosure): self
    {
        $this->dateOfClosure = $dateOfClosure;

        return $this;
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setEvent($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->contains($survey)) {
            $this->surveys->removeElement($survey);
            // set the owning side to null (unless already changed)
            if ($survey->getEvent() === $this) {
                $survey->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }


}
