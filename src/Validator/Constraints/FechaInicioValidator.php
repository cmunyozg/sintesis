<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FechaInicioValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $today = new \DateTime('today');

        if ($value < $today) {

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
