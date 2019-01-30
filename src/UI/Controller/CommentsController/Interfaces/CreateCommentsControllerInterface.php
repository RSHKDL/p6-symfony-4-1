<?php

namespace App\UI\Controller\CommentsController\Interfaces;

use App\Domain\Entity\Trick;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface CreateCommentsControllerInterface
{

    /**
     * @param Request $request
     * @param Trick $trick
     * @return Response
     */
    public function createComments(Request $request, Trick $trick): Response;

    /**
     * @param Trick $trick
     * @return Response
     */
    public function renderCommentsForm(Trick $trick): Response;
}
