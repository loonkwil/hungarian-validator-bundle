<?php

namespace SPE\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VatNumber extends Constraint
{
    public $message = "It is not a valid VAT number";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
