<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Service\SlugGeneratorService;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FiliereRepository")
 */
class Filiere
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $urlSlug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $candidate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $titleBlock1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBlock1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $titleBlock2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBlock2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $titleBlock3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBlock3;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $titleBlock4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBlock4;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $titleBlock5;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textBlock5;

    public function __construct()
    {
//        $this->initUrlSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCandidate(): ?string
    {
        return $this->candidate;
    }

    public function setCandidate(?string $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitleBlock1(): ?string
    {
        return $this->titleBlock1;
    }

    public function initUrlSlug(): string
    {
        $slugGeneratorService = new SlugGeneratorService($this->title);
        $this->urlSlug = $slugGeneratorService->getSlug();

        return $this;
    }

    public function setTitleBlock1(?string $titleBlock1): self
    {
        $this->titleBlock1 = $titleBlock1;

        return $this;
    }

    public function getTextBlock1(): ?string
    {
        return $this->textBlock1;
    }

    public function setTextBlock1(?string $textBlock1): self
    {
        $this->textBlock1 = $textBlock1;

        return $this;
    }

    public function getTitleBlock2(): ?string
    {
        return $this->titleBlock2;
    }

    public function setTitleBlock2(?string $titleBlock2): self
    {
        $this->titleBlock2 = $titleBlock2;

        return $this;
    }

    public function getTextBlock2(): ?string
    {
        return $this->textBlock2;
    }

    public function setTextBlock2(?string $textBlock2): self
    {
        $this->textBlock2 = $textBlock2;

        return $this;
    }

    public function getTitleBlock3(): ?string
    {
        return $this->titleBlock3;
    }

    public function setTitleBlock3(?string $titleBlock3): self
    {
        $this->titleBlock3 = $titleBlock3;

        return $this;
    }

    public function getTextBlock3(): ?string
    {
        return $this->textBlock3;
    }

    public function setTextBlock3(?string $textBlock3): self
    {
        $this->textBlock3 = $textBlock3;

        return $this;
    }

    public function getTitleBlock4(): ?string
    {
        return $this->titleBlock4;
    }

    public function setTitleBlock4(?string $titleBlock4): self
    {
        $this->titleBlock4 = $titleBlock4;

        return $this;
    }

    public function getTextBlock4(): ?string
    {
        return $this->textBlock4;
    }

    public function setTextBlock4(?string $textBlock4): self
    {
        $this->textBlock4 = $textBlock4;

        return $this;
    }

    public function getTitleBlock5(): ?string
    {
        return $this->titleBlock5;
    }

    public function setTitleBlock5(?string $titleBlock5): self
    {
        $this->titleBlock5 = $titleBlock5;

        return $this;
    }

    public function getTextBlock5(): ?string
    {
        return $this->textBlock5;
    }

    public function setTextBlock5(?string $textBlock5): self
    {
        $this->textBlock5 = $textBlock5;

        return $this;
    }

    public function getTitleBlock6(): ?string
    {
        return $this->titleBlock6;
    }

    public function setTitleBlock6(?string $titleBlock6): self
    {
        $this->titleBlock6 = $titleBlock6;

        return $this;
    }

    public function getTextBlock6(): ?string
    {
        return $this->textBlock6;
    }

    public function setTextBlock6(?string $textBlock6): self
    {
        $this->textBlock6 = $textBlock6;

        return $this;
    }
}
