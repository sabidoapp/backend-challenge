<?php

declare(strict_types=1);

namespace App\Controller\Vote;

use App\Controller\BaseController;
use App\Entity\Vote\Vote;
use App\Form\Vote\VoteType;
use App\Repository\Vote\VoteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vote", name="vote_")
 */
class VoteController extends BaseController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(VoteRepository $voteRepository): JsonResponse
    {
        return $this->response(
            [
                'votes' => $voteRepository->findAll(),
            ],
            ['list']
        );
    }

    /**
     * @Route("", name="new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vote);
            $em->flush();

            $this->addFlash('success', $this->trans('controller.success.new', [], 'vote'));

            return $this->response(
                [
                    'vote' => $vote,
                ],
                ['show']
            );
        }

        $this->renderErrors($form, 'vote');

        return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Vote $vote): JsonResponse
    {
        return $this->response(
            [
                'vote' => $vote,
            ],
            ['show']
        );
    }
}
