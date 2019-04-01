<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Service\SlugGeneratorService;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
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
     * @ORM\Column(type="string")
     */
    private $urlSlug;

    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sections;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->initUrlSlug();
        $this->sections = new ArrayCollection();
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

    public function getUrlSlug(): ?string
    {
        return $this->urlSlug;
    }

    public function initUrlSlug(): self
    {
        $slugGeneratorService = new SlugGeneratorService($this->title);
        $this->urlSlug = $slugGeneratorService->getSlug();

        return $this;
    }

    public function setUrlSlug(string $urlSlug): self
    {
        $this->urlSlug = $urlSlug;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setPage($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getPage() === $this) {
                $section->setPage(null);
            }
        }

        return $this;
    }
}
