<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BusinessRegistrationNumber extends Constraint
{
    public $message = "It is not a valid business registration number";

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

