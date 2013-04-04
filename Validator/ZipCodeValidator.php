<?php

namespace SPE\HungarianValidatorBundle\Validator;

/**
 * iranyitoszam ellenorzese
 */
class ZipCodeValidator extends HungarianValidator
{
    protected $pattern = '/^(?:1(?:[01][1-9]|2[1-3])[0-9]|[2-9][0-9]{3})$/';
}
