<?php
namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends Exception
{
    private $violations;

    public function __construct(ConstraintViolationList $violations)
    {
        $this->code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->violations = $this->violationsToArray($violations);

    }

    public function getMessages()
    {

        $messages = [];
        foreach ($this->violations as $paramName => $violationList) {
            foreach ($violationList as $violation) {
                $messages[$paramName][] = $violation;
            }
        }
        return $messages;
    }

    public function getJoinedMessages()
    {
        $messages = [];
        foreach ($this->violations as $paramName => $violationList) {
            foreach ($violationList as $violation) {
                $messages[$paramName][] = $violation->getMessage();
            }
            $messages[$paramName] = implode(' ', $messages[$paramName]);
        }
        return $messages;
    }

    protected function violationsToArray(ConstraintViolationList $violations)
    {
        $messages = [];

        foreach ($violations as $constraint) {
            $prop = preg_replace("/^\\[(.*?)\]\$/", "$1", $constraint->getPropertyPath());
            $messages[$prop][] = $constraint->getMessage();
        }

        return $messages;
    }

}