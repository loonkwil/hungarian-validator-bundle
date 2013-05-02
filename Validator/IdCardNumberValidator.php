<?php

namespace SPE\HungarianValidatorBundle\Validator;

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
class IdCardNumberValidator extends HungarianValidator
{
    /**
     * @var string $newPattern Minta az uj tipusu (muanyag) kartyak
     *     ellenorzesere
     */
    protected $newPattern = '/
        ^
        [0-9]{6}
        [\- ]?
        [a-zA-Z]{2}
        $
        /x';

    /**
     * A romai szam regex mintaja innen:
     * http://stackoverflow.com/questions/267399/how-do-you-match-only-valid-roman-numerals-with-a-regular-expression
     *
     * @var string $oldPatter Minta a regi (kemeny fedeles) kartyak
     *     ellenorzesere. 2016. december 31-ig meg ervenyben vannak
     */
    protected $oldPattern = '/
        ^
        [a-zA-Z]{2}
        [\- ]?
        (?:                # romai szam
            M{0,4}         # ezresek
            CM|CD|D?C{0,3} # szazasok
            XC|XL|L?X{0,3} # tizesek
            IX|IV|V?I{0,3} # egyesek
            [\- ]?
        )?
        [0-9]{6}
        $
        /x';

    protected function check($value)
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

        return true;
    }
}
