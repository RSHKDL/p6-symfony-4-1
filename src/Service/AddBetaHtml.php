<?php

namespace App\Service;

use App\Service\Interfaces\AddBetaHtmlInterface;
use Symfony\Component\HttpFoundation\Response;

/*
 * Add a "Beta" tag for x remaining days at the end of the <body>
 */
final class AddBetaHtml implements AddBetaHtmlInterface
{

    /**
     * @inheritdoc
     */
    public function addBeta(Response $response, int $remainingDays): Response
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
