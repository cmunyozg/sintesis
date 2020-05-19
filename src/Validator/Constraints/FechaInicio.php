<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FechaInicio extends Constraint
{
    public $message = 'La fecha de inicio debe ser actual.';
}
