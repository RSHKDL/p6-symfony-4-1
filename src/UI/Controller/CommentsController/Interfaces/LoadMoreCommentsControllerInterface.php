<?php

namespace App\UI\Controller\CommentsController\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface LoadMoreCommentsControllerInterface
{

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function loadMoreComments(Request $request, int $id): JsonResponse;
}
