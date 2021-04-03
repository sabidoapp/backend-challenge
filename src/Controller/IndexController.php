<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $this->addFlash('info', $this->trans('controller.success', [], 'main'));

        return $this->response([]);
    }
}
