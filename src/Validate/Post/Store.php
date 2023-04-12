<?php
namespace App\Validate\Post;

use App\Validate\Validate;
use App\Validate\Constraint\UserExists;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;

class Store extends Validate
{

    protected $constraints = [];

    public function __construct()
    {

        $this->constraints = [
            'userId' => [
                new Required(),
                new Type('numeric'),
                new GreaterThan(0),
                new UserExists()
            ],
            'title' => [
                new Required(),
                new Type('string'),
                new Length(['min' => 3, 'max' => 255])
            ],
            'body' => [
                new Required(),
                new Type('string'),
                new Length(['min' => 3])
            ]
        ];

    }

}