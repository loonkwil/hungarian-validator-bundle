<?php

namespace SPE\HungarianValidatorBundle\Validator;

class FullNameValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        \s*          # feher szokozok megengedettek a nev elott (es utan is)
        [^0-9 ]+     # nev eslo resze
        (?:
            \s+      # reszeket elvalaszto feher szokoz
            [^0-9 ]+ # nev masodik resze
        )+
        \s*
        $
        /x';
}
