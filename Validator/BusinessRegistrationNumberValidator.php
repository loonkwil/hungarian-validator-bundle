<?php

namespace SPE\HungarianValidatorBundle\Validator;

/**
 * cegjegyzekszam ellenorzese
 *
 * A BS-CF-NNNNNN formátumú cégjegyzékszám három jól elkülöníthető részből áll:
 * BS a céget nyilvántartó bíróság két számjegyű sorszáma,
 * CF a cégformára utaló két számjegyű jelzőszám,
 * NNNNNN pedig a cégjegyzéket vezető bíróságon kiadott hat számjegyből álló sorszám.
 *
 * http://hu.wikipedia.org/wiki/C%C3%A9gjegyz%C3%A9ksz%C3%A1mok_Magyarorsz%C3%A1gon
 */
class BusinessRegistrationNumberValidator extends HungarianValidator
{
    protected $pattern = '/^(?:[01][0-9]|20)[\- ]?(?:[01][0-9]|2[0-3])[\- ]?[0-9]{6}$/';
}
