<?php
namespace App\Validate;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

class Validate
{

    protected $constraints = [];

    public function validate(array $data) {

        $validator = Validation::createValidator();
        $errors = $validator->validate($data, new Collection($this->constraints));
        if (0 !== count($errors)) {
            throw new ValidationException($errors);
        }

    }

}