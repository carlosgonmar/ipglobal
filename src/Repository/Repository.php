<?php

namespace App\Repository;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;

/**
 *
// * @method Post|null find($id, $lockMode = null, $lockVersion = null)
// * @method Post|null findOneBy(array $criteria, array $orderBy = null)
// * @method Post[]    all()
// * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Repository
{

    protected string $entity = "";
    protected const METHOD_GET = 'GET';
    protected const METHOD_POST = 'POST';

    /**
     * @desc The model class name
     *
     * @var string
     */
    protected string $model = "";

    /**
     * @desc Find all posts
     *
     * @var array
     */
    public function callDatabase(string $url, string $method, array $parameters = [], array $headers = [])
    {
        $options = [
            'body' => $parameters,
            'headers' => $headers,
        ];
        $response = HttpClient::create()->request(
            $method,
            $url,
            $options
        );
        if(
            $response->getStatusCode() === Response::HTTP_OK
            || $response->getStatusCode() === Response::HTTP_CREATED
        ){
            return $response->toArray();
        }elseif($response->getStatusCode() === Response::HTTP_NOT_FOUND){
            throw new \Exception('Item not found', Response::HTTP_NOT_FOUND);
        }else{
            throw new \Exception('Unknown error', Response::HTTP_CONFLICT);
        }
    }

    /**
     * @desc Find all posts
     *
     * @var array
     */
    public function all(): Array
    {

        $url = $_ENV['TYPICODE_BASE_URL'].$this->model;
        $response = $this->callDatabase($url, self::METHOD_GET);
        $items = [];
        foreach ($response as $values){
            $item = new $this->entity($values);
            $items[] = $item;
        }
        return $items;

    }

    /**
     * @desc Find all posts as array
     *
     * @var array
     */
    public function allAsArray(): array
    {

        $items = $this->all();
        foreach ($items as &$item){
            $item = $item->toArray();
        }
        return $items;

    }

    /**
     * @desc Find one post by id
     *
     * @param int $id
     *
     * @return Entity|Null
     */
    public function find(int $id): ?object
    {

        try {

            return $this->findOrFail($id);

        } catch (\Exception $e) {
            if ($e->getCode() == Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw $e;
        }

    }

    /**
     * @desc Find one post by id
     *
     * @param int $id
     *
     * @return Entity|Null
     */
    public function findOrFail(int $id): ?object
    {

        if(class_exists($this->entity)) {
            $url = $_ENV['TYPICODE_BASE_URL'] . $this->model . '/' . $id;
            $response = $this->callDatabase($url, self::METHOD_GET);
            return new $this->entity($response);
        }
        throw new \Exception('Entity \"'.$this->entity.'\" not found', Response::HTTP_BAD_REQUEST);

    }

}
