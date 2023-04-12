<?php

namespace App\Controller\Api\User;

use App\Controller\Controller;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */

class IndexController extends Controller
{

    /**
     * @Route("/users", name="users_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->jsonResponse((new UserRepository())->allAsArray());
    }
}