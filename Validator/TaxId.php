<?php

namespace SPE\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TaxId extends Constraint
{
    public $message = "It is not a valid tax ID";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
