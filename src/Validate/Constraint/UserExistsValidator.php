<?php
namespace App\Validate\Constraint;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserExistsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value)) {
            throw new UnexpectedValueException($value, 'numeric');
        }

        $userRepository = new UserRepository();
        if ($userRepository->find($value) === null) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}