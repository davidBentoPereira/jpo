<?php

namespace App\Entity;

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

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->initUrlSlug();
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
}
