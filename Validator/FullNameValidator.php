<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class FullNameValidator extends ConstraintValidator
{
    protected $pattern = '/^[^0-9]+(?: [^0-9]+)+$/';

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

    private function checkFullName($value)
    {
        return preg_match($this->pattern, $value);
    }
}
