<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PersonalIdCardNumberValidator extends ConstraintValidator
{
    protected $pattern = '/^[0-9]{6}[\- ]?[a-zA-Z]{2}$/';

    public function isValid($value, Constraint $constraint)
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

        $ret = $this->checkPersonalIdCardNumber($value);

        if( !$ret ) {
            $this->setMessage($constraint->message);
        }

        return $ret;
    }

    /**
     * szemelyazonosito igazolvany (kartya) szam ellenorzese
     *
     * A szemelyi igazolvany jobb felos sarkaban talalhato szam
     */
    private function checkPersonalIdCardNumber($value)
    {
        return preg_match($this->pattern, $value, $matches);
    }
}
