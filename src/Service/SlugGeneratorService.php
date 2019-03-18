<?php

namespace App\Service;

class SlugGeneratorService
{
    private $slug;

    public function __construct(string $stringToSlugify)
    {
        $stringToSlugify = strtolower($stringToSlugify);
        $stringToSlugify = str_replace(" ", "-", $stringToSlugify);
        $this->slug = $stringToSlugify;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}