<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ZipCode extends Constraint
{
    public $message = "It is not a valid ZIP code";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}

