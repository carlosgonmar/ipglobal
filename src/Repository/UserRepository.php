<?php

namespace App\Repository;

class UserRepository extends Repository
{


    /**
     * @desc The entity class name
     *
     * @var string
     */
    protected string $entity = "\App\Entity\User";

    /**
     * @desc The model class name
     *
     * @var string
     */
    protected string $model = "users";

}
