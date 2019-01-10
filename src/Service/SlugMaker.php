<?php

namespace App\Service;

use App\Service\Interfaces\SlugMakerInterface;

final class SlugMaker implements SlugMakerInterface
{

    /**
     * @inheritdoc
     */
    public function slugify(string $text, bool $slug = true): string
    {
        // replace non letter or digits by - or _
        if ($slug) {
            $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        } else {
            $text = preg_replace('#[^\\pL\d]+#u', '_', $text);
        }
        // trim
        $text = trim($text, '-');
        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
        return $text;
    }
}
