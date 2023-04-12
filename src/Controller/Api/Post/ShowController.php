<?php

namespace App\Controller\Api\Post;

use App\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */

class ShowController extends Controller
{

    /**
     * @Route("/posts/{id}", name="posts_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        return $this->jsonResponse((new PostRepository())->findOrFail($id)->with("user")->toArray());
    }

}