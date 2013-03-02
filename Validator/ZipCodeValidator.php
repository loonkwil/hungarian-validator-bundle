<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ZipCodeValidator extends ConstraintValidator
{
    protected $pattern = '/^[1-9][0-9]{3}$/';

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

        $ret = $this->checkZipCode($value);

        if( !$ret ) {
            $this->context->addViolation($constraint->message);
        }

        return $ret;
    }

    /**
     * iranyitoszam ellenorzese
     */
    private function checkZipCode($value)
    {
        return preg_match($this->pattern, $value);
    }
}