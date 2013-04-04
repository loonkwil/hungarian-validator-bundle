<?php

namespace SPE\HungarianValidatorBundle\Validator;

class FullNameValidator extends HungarianValidator
{
    protected $pattern = '/^[^0-9]+(?: [^0-9]+)+$/';
}
