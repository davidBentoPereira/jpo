<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="responses")
     */
    private $question;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="QuestionOption")
     */
    private $options;

    public function __construct()
    {
//        $this->responseValue = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

//    /**
//     * @return Collection|ResponseValue[]
//     */
//    public function getResponseValue(): Collection
//    {
//        return $this->responseValue;
//    }

//    public function addResponseValue(ResponseValue $responseValue): self
//    {
//        if (!$this->responseValue->contains($responseValue)) {
//            $this->responseValue[] = $responseValue;
//            $responseValue->setResponse($this);
//        }
//
//        return $this;
//    }

//    public function removeResponseValue(ResponseValue $responseValue): self
//    {
//        if ($this->responseValue->contains($responseValue)) {
//            $this->responseValue->removeElement($responseValue);
//            // set the owning side to null (unless already changed)
//            if ($responseValue->getResponse() === $this) {
//                $responseValue->setResponse(null);
//            }
//        }
//
//        return $this;
//    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|QuestionOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(QuestionOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(QuestionOption $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
        }

        return $this;
    }
}
