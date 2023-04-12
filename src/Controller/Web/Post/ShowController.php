<?php

namespace App\Controller\Web\Post;

use App\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends Controller
{

    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }


    /**
     * @Route("/posts/{id}", name="posts_show", methods={"GET"})
     */
    public function show(int $id): Response
    {

        $post = $this->postRepository->find($id);
        $posts = $this->postRepository->allAsArray();
        $posts = array_slice($posts, (count($posts)-10), count($posts));
        if($post){
            return $this->render('post.html.twig', [
                'post' => $post->with("user")->toArray(),
                'posts' => $posts,
            ]);
        }
        return $this->render('error.html.twig', ['code' => Response::HTTP_NOT_FOUND]);
    }
}