<?php

namespace App\Controller\Api\Post;

use App\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */

class IndexController extends Controller
{

    /**
     * @Route("/posts", name="posts_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->jsonResponse((new PostRepository())->allAsArray());
    }
}