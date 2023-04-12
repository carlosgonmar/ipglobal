<?php

namespace App\Controller\Api\Post;

use App\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Validate\Post\Store as ValidatePostStore;

/**
 * @Route("/api", name="api_")
 */
class StoreController extends Controller
{

    /**
     * @Route("/posts", name="posts_store", methods={"POST"})
     */
    public function store(Request $request): Response
    {

        (new ValidatePostStore())->validate($request->request->all());
        return $this->jsonResponse((new PostRepository())->store($request)->with("user")->toArray(), Response::HTTP_CREATED);

    }
}
