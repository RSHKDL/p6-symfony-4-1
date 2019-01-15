<?php

namespace App\Controller\CommentsController;

use App\Entity\Trick;
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
            $figure = $this->getDoctrine()->getRepository(Trick::class)->find($id);
            /** @var Collection $comments */
            $comments = $figure->getComments();
            $batch = $comments->slice($offset,5);

            $template = $this
                ->render('trick/_comment_view.html.twig', [
                    'comments' => $batch,
                    'offset' => $offset+5
                ])
                ->getContent();
            return new JsonResponse($template);
        }
        return new JsonResponse('No results');
    }
}
