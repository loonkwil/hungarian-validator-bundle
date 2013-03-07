<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PersonalIdValidator extends ConstraintValidator
{
    protected $pattern = '/^([1-8])[\- ]?([0-9]{2}(?:0[1-9]|1[12])(?:0[1-9]|[12][0-9]|3[01]))[\- ]?([0-9]{3})([0-9])$/';

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

        if( !$this->checkPersonalId($value) ) {
            $this->context->addViolation($constraint->message);
        }
    }

    /**
     * szemelyi szam ellenorzese
     *
     * A szemelyi szam ugy nevezett „beszelo szam”, azaz strukturaja van. 11
     * decimalis szamjegybol all es M EEHHNN SSSK alaku.
     * Az M szamjegy jelentese komplikalt. Alapvetoen a nemre es a szuletesi ev
     * elso ket jegyere utal. Az 1997. januar 1. elott szuletettek eseteben
     * tartalmazta az allampolgarsagot is. Ld. alabb.
     * Az EEHHNN szamjegyek a szuletesi ev utolso ket jegyet, a honapot es a napot
     * kodoljak.
     * Az SSS az azonos napon szuletettek megkulonboztetesere valo.
     * A K ellenorzesi celokat szolgal. A tobbi szamjegybol kell kepezni.
     * Egyszerubb hibak, elutesek detektalhatok a segitsegevel.
     *
     * http://hu.wikipedia.org/wiki/Szem%C3%A9lyi_sz%C3%A1m
     */
    private function checkPersonalId($value)
    {
        if( preg_match($this->pattern, $value, $matches) === 0 ) {
            return false;
        }

        // 18..-ban szuletetteket ezaltal kizartam
        $datePrefix = ( in_array($matches[1], array('3', '4')) ) ? '20' : '19';

        $year = $datePrefix . substr($matches[2], 0, 2);
        $month = substr($matches[2], 2, 2);
        $day = substr($matches[2], 4, 2);

        if( !checkdate($month, $day, $year) ) {
            return false;
        }

        $withoutSeparators = '';
        for( $i = 1; $i < count($matches); ++$i ) {
            $withoutSeparators .= $matches[$i];
        }

        $sum = 0;
        for( $i = 0; $i < 10; ++$i ) {
            $sum += (int)$withoutSeparators[$i] * ($i + 1);
        }

        return ($sum % 11) === (int)$matches[4];
    }
}
