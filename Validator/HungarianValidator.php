<?php

namespace SPE\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HungarianValidator extends ConstraintValidator
{
    protected $pattern;

    /**
     * @param string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if( !$this->haveToValidate($value) ) {
            return;
        }

        if( !$this->isValidType($value) ) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $isValid = $this->check($value);
        if( !$isValid ) {
            $this->context->addViolation($constraint->message);
        }
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function haveToValidate($value)
    {
        return ($value !== null && $value !== '');
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function isValidType($value)
    {
        return (
            is_scalar($value) || (is_object($value) && method_exists($value, '__toString'))
        );
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function check($value)
    {
        return preg_match($this->pattern, $value);
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function checkSum($value)
    {
        // felesleges elvalaszto karakterek eltavolitasa
        $value = preg_replace('/[^0-9]/', '', $value);

        $sum = 0;
        $l = strlen($value);
        for( $i = 0; $i < $l - 1; ++$i ) {
            $sum += (int)$value[$i] * ($i + 1);
        }

        return (($sum % 11) === (int)$value[$l - 1]);
    }
}
