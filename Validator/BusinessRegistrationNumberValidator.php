<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class BusinessRegistrationNumberValidator extends ConstraintValidator
{
    protected $pattern = '/^(?:[01][0-9]|20)[\- ]?(?:[01][0-9]|2[0-3])[\- ]?[0-9]{6}$/';

    public function validate($value, Constraint $constraint)
    {
        if( null === $value || '' === $value ) {
            return;
        }

        if(
            !is_scalar($value) && !(is_object($value) &&
            method_exists($value, '__toString'))
        ) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $ret = $this->checkFullName($value);

        if( !$ret ) {
            $this->context->addViolation($constraint->message);
        }

        return $ret;
    }

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
    private function checkFullName($value)
    {
        return preg_match($this->pattern, $value);
    }
}
