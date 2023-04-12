<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use \Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends AbstractController
{

    protected ValidatorInterface $validator;
    private const STATUS_SUCCESS = "success";

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $data
     * @param int $status
     * @param array $headers
     * @param array $context
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonResponse($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {

        return $this->json(['status' => self::STATUS_SUCCESS, "data" => $data], $status, $headers, $context);

    }



}