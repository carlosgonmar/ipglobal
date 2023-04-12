<?php
namespace App\Validate\Constraint;

use Symfony\Component\Validator\Constraint;

class UserExists extends Constraint
{
    public string $message = 'The user "{{ string }}" does not exist.';
    // If the constraint has configuration options, define them as public properties
    public string $mode = 'strict';
}