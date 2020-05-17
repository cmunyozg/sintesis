<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MoreThan16 extends Constraint
{
    public $message = 'La edad mínina permitida es de 16 años.';
}
