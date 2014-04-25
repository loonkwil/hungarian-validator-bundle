<?php

namespace SPE\HungarianValidatorBundle\Validator;

/**
 * iranyitoszam ellenorzese
 */
class ZipCodeValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        (?:
        1                    # Budapest
        (?:[01][0-9]|2[1-3]) # 00 Margitsziget, 01-tol 23-ig kerulet
        [0-9]
        |
        [2-9][0-9]{3}        # videk
        )
        $
        /x';
}
