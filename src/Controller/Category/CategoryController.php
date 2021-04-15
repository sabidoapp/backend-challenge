<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\BaseController;
use App\Entity\Category\Category;
use App\Form\Category\CategoryType;
use App\Repository\Category\CategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends BaseController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        return $this->response(
            ['categories' => $categoryRepository->findAll()],
            ['list']
        );
    }

    /**
     * @Route("", name="new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', $this->trans('controller.success.new', [], 'category'));

            return $this->response(
                ['category' => $category],
                ['show']
            );
        }
        
        $this->renderErrors($form, 'category');

        return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Category $category): JsonResponse
    {
        return $this->response(
            ['category' => $category],
            ['show', 'stats']
        );
    }

    /**
     * @Route("/{id}", name="update", methods={"PATCH"})
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $form = $this->createForm(CategoryType::class, $category, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $this->trans('controller.success.update', [], 'category'));

            return $this->response(
                ['category' => $category],
                ['show']
            );
        }
        
        $this->renderErrors($form, 'category');

        return $this->response([], [], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Category $category): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', $this->trans('controller.success.delete', [], 'category'));

        return $this->response([]);
    }
}
