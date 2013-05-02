<?php

namespace SPE\HungarianValidatorBundle\Validator;

/**
 * cegjegyzekszam ellenorzese
 *
 * A BS-CF-NNNNNN formatumu cegjegyzekszam harom jol elkulonitheto reszbol all:
 * BS a ceget nyilvantarto birosag ket szamjegyu sorszama,
 * CF a cegformara utalo ket szamjegyu jelzoszam,
 * NNNNNN pedig a cegjegyzeket vezeto birosagon kiadott hat szamjegybol allo sorszam.
 *
 * http://hu.wikipedia.org/wiki/C%C3%A9gjegyz%C3%A9ksz%C3%A1mok_Magyarorsz%C3%A1gon
 */
class BusinessRegistrationNumberValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        (?:[01][0-9]|20)     # 01-tol 20-ig
        [\- ]?               # elvalaszo jel
        (?:[01][0-9]|2[0-3]) # 01-tol 23-ig
        [\- ]?
        [0-9]{6}
        $
        /x';
}
