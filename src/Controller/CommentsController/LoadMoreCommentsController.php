<?php

namespace App\Controller\CommentsController;

use App\Entity\Figure;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class LoadMoreCommentsController extends AbstractController
{

    /**
     * @Route("/trick/{id}/comment",
     *     methods={"POST"},
     *     name="comments_load_more",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function loadMoreComments(Request $request, int $id): JsonResponse
    {
        if($request->isXmlHttpRequest()) {
            $offset = $request->request->get('offset');
            $figure = $this->getDoctrine()->getRepository(Figure::class)->find($id);
            /** @var Collection $comments */
            $comments = $figure->getComments();

            $batch = [];
            foreach($comments->slice($offset,3) as $comment) {
                $batch[] = [
                    'id' => $comment->getId(),
                    'content' => $comment->getContent(),
                ];
            }

            $data = [
                'batch' => $batch,
                'offset' => $offset+3
            ];
            return new JsonResponse($data);
        }
        return new JsonResponse('No results');
    }
}
