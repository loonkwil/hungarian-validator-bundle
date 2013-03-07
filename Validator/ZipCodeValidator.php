<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ZipCodeValidator extends ConstraintValidator
{
    protected $pattern = '/^(?:1(?:[01][1-9]|2[1-3])[0-9]|[2-9][0-9]{3})$/';

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

        if( !$this->checkZipCode($value) ) {
            $this->context->addViolation($constraint->message);
        }
    }

    /**
     * iranyitoszam ellenorzese
     */
    private function checkZipCode($value)
    {
        return preg_match($this->pattern, $value);
    }
}
