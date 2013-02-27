<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PersonalIdCardNumber extends Constraint
{
    public $message = "It is not a valid personal ID card number";

    public function requiredOptions()
    {
        return array();
    }

    public function defaultOption()
    {
        return '';
    }

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}

