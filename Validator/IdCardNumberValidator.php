<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IdCardNumberValidator extends ConstraintValidator
{
    /**
     * @type string $newPattern Minta az uj tipusu (muanyag) kartyak
     *     ellenorzesere
     */
    protected $newPattern = '/^[0-9]{6}[\- ]?[a-zA-Z]{2}$/';

    /**
     * @type string $oldPatter Minta a regi (kemeny fedeles) kartyak
     *     ellenorzesere. 2016. december 31-ig meg ervenyben vannak
     */
    protected $oldPattern = '/[a-zA-Z]{2}[\- ]?(?:([A-Z]+)[\- ]?)?[0-9]{6}/';

    /**
     * from: http://stackoverflow.com/questions/267399/how-do-you-match-only-valid-roman-numerals-with-a-regular-expression
     * @type string $romanNumbers Minta a romai szamok ellenorzesere
     */
    protected $romanNumbers = '/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/';

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

        $ret = $this->checkIdCardNumber($value);

        if( !$ret ) {
            $this->context->addViolation($constraint->message);
        }

        return $ret;
    }

    /**
     * szemelyazonosito igazolvany (kartya) szam ellenorzese
     *
     * formatuma:
     *     uj (muanyag) kartya: 6 szamjegy + 2 betu, pl.: 123456AA
     *     regi (kemeny fedeles) kartya:
     *         2 betu + szokoz + 6 szamjegy, pl.: AE 232323
     *         2 betu + kotojel + romai szam + szokoz + 6 szamjegy, pl.: AU-I 123456
     *
     * http://www.telenor.hu/sugo/netshop/Page13.html
     */
    private function checkIdCardNumber($value)
    {
        // uj tipusu kartya
        if( preg_match($this->newPattern, $value) ) {
            return true;
        }

        // A regi kartyak csak 2016. december 31-ig ervenyesek
        if( date('Y') > 2016 ) {
            return false;
        }

        if( preg_match($this->oldPattern, $value, $matches) === 0 ) {
            return false;
        }

        // nem tartalmaz romai szamot
        if( count($matches) !== 2 ) {
            return true;
        }

        // romai szam validalasa
        return preg_match($this->romanNumbers, $matches[1]);
    }
}
