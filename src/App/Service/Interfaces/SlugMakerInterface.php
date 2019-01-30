<?php

namespace App\App\Service\Interfaces;

/**
 * Interface SlugMakerInterface
 * @package App\App\Service\Interfaces
 */
interface SlugMakerInterface
{
    /**
     * Transform a string to an url friendly slug
     * or a directory friendly name, if slug is false
     *
     * @param string $text
     * @param bool $slug
     * @return string
     */
    public function slugify(string $text, bool $slug = true): string;
}
