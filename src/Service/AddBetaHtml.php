<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

/*
 * Add a "Beta" tag for x remaining days at the end of the <body>
 */
class AddBetaHtml
{

    public function addBeta(Response $response, int $remainingDays)
    {
        $content = $response->getContent();
        $html = '<div class="beta-banner">
            <span class="fas fa-flask" aria-hidden="true"></span>
             <i>Project in Beta, '.$remainingDays.' days left.</i></div>';
        $content = str_replace(
            '<body>',
            '<body> '.$html,
            $content
        );

        $response->setContent($content);
        return $response;
    }
}
