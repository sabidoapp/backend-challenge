<?php

declare(strict_types=1);

namespace App\Controller\Indicated;

use App\Controller\BaseController;
use App\Entity\Indicated\Indicated;
use App\Form\Indicated\IndicatedType;
use App\Repository\Indicated\IndicatedRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/indicated", name="indicated_")
 */
class IndicatedController extends BaseController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(IndicatedRepository $indicatedRepository): JsonResponse
    {
        return $this->response(
            ['indicated' => $indicatedRepository->findAll()],
            ['list']
        );
    }

    /**
     * @Route("", name="new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $indicated = new Indicated();
        $form = $this->createForm(IndicatedType::class, $indicated);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($indicated);
            $em->flush();

            $this->addFlash('success', $this->trans('controller.success.new', [], 'indicated'));

            return $this->response(
                ['indicated' => $indicated],
                ['show']
            );
        }
            ($this->renderErrors())($form, 'indicated');

        return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Indicated $indicated): JsonResponse
    {
        return $this->response(
            ['indicated' => $indicated],
            ['show', 'stats']
        );
    }

    /**
     * @Route("/{id}", name="update", methods={"PATCH"})
     */
    public function update(Request $request, Indicated $indicated): JsonResponse
    {
        $form = $this->createForm(IndicatedType::class, $indicated, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $this->trans('controller.success.update', [], 'indicated'));

            return $this->response(
                ['indicated' => $indicated],
                ['show']
            );
        }
            ($this->renderErrors())($form, 'indicated');

        return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Indicated $indicated): JsonResponse
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($indicated);
            $em->flush();

            $this->addFlash('success', $this->trans('controller.success.delete', [], 'indicated'));

            return $this->response([]);
        } catch (\Throwable $e) {
            return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
