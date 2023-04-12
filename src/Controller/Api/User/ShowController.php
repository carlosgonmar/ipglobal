<?php

namespace App\Controller\Api\User;

use App\Controller\Controller;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */

class ShowController extends Controller
{

    /**
     * @Route("/users/{id}", name="users_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        return $this->jsonResponse((new UserRepository())->findOrFail($id)->toArray());
    }

}