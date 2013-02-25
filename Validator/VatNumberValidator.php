<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class VatNumberValidator extends ConstraintValidator
{
    protected $pattern = '/^[0-9]{8}[\- ]?[1-5][\- ]?(?:51|4[0-4]|3[0-9]|2[02-9]|1[0-9]|0[2-9])$/';

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

        $ret = $this->checkVatNumber($value);

        if( !$ret ) {
            $this->setMessage($constraint->message);
        }

        return $ret;
    }

    /**
     * adoszam ellenorzese
     *
     * A 11 jegyu adoszam szerkezeti felepitese a kovetkezo:
     * xxxxxxxx-y-zz
     * ahol:
     *  - xxxxxxxx az adozot egyertelmuen azonosito torzsszam.
     *  - y az un. afakod. A foszabaly szerint csak "2"-es, illetve "3"-as afakodu
     *    adoalany (ez utobbi az EVA alanya) altal kibocsatott szamla tartalmazhat
     *    atharitott afat. Bizonyos esetekben helyes az "1"-es afakod mellett is az
     *    ado felszamitasa es atharitasa.
     *  - zz az adozo szekhelye szerint illetekes teruleti adohatosag kodja
     *
     * http://hu.wikipedia.org/wiki/Ad%C3%B3sz%C3%A1m
     *
     * Az AFA kodok a kovetkezok lehetnek:
     * AFA kod = 1 , ekkor az adozo adomentes adoalany;
     * AFA kod = 2 , ekkor az adozo altalanos szabalyok szerint adozo adoalany;
     * AFA kod = 3 , ekkor az adozo EVA-s adoalany;
     * AFA kod = 4 , ebben az esetben az adozo csoportos adoalanyisaganak jelzese;
     * AFA kod = 5 , ez a csoportos adoalanyisag eseten a csoport adoszama.
     *
     * http://www.partnercontrol.hu/default.asp?page=tudastar&gyp=3
     */
    private function checkVatNumber($value)
    {
        return preg_match($this->pattern, $value);
    }
}
