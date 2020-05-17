<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MoreThan16Validator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $now = new \DateTime();
        $nowMinus16y = $now->modify('-16 years');

        if ($value > $nowMinus16y) {

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
