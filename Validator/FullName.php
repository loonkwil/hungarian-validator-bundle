<?php

namespace SPE\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullName extends Constraint
{
    public $message = "Please enter your full name";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
