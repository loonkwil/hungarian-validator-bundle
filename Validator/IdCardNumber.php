<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IdCardNumber extends Constraint
{
    public $message = "It is not a valid personal ID card number";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
