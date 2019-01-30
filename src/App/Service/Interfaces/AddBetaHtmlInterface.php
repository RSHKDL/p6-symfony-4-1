<?php

namespace App\App\Service\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface AddBetaHtmlInterface
{

    /**
     * @param Response $response
     * @param int $remainingDays
     * @return Response
     */
    public function addBeta(Response $response, int $remainingDays): Response;
}
