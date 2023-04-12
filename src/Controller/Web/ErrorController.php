<?php

namespace App\Controller\Web;

use App\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends Controller
{

    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    /**
     * @Route("/*", name="posts_sindex", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('homepage.html.twig', [
            'posts' => $this->postRepository->allAsArray(),
        ]);
    }
}