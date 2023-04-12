<?php

namespace App\Repository;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

/**
 *
// * @method Post|null find($id, $lockMode = null, $lockVersion = null)
// * @method Post|null findOneBy(array $criteria, array $orderBy = null)
// * @method Post[]    all()
// * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends Repository
{

    /**
     * @desc The entity class name
     *
     * @var string
     */
    protected string $entity = "\App\Entity\Post";

    /**
     * @desc The model class name
     *
     * @var string
     */
    protected string $model = "posts";



    /**
     * @desc Store a new post
     *
     * @param array $data
     *
     * @return Post|Null
     */
    public function store(Request $request): ?Post
    {

        $url = $_ENV['TYPICODE_BASE_URL'].$this->model;
        $parameters = [
            'userId' => $request->get('userId'),
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ];
        $response = $this->callDatabase($url, self::METHOD_POST, $parameters);
        $post = new Post($response);
        return $post;


    }

}
