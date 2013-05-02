<?php

namespace SPE\HungarianValidatorBundle\Validator;

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
class PersonalIdValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        ([1-8])
        [\- ]?
        ([0-9]{2})               # szuletesi ev utolso ket jegye
        (0[1-9]|1[12])           # honap
        (0[1-9]|[12][0-9]|3[01]) # nap
        [\- ]?
        [0-9]{3}
        [0-9]                    # ellenorzo szam
        $
        /x';

    protected function check($value)
    {
        if( preg_match($this->pattern, $value, $matches) === 0 ) {
            return false;
        }

        // 19. szazadban szuletetteket ezaltal kizartam
        $yearPrefix = ( in_array($matches[1], array('3', '4')) ) ? '20' : '19';

        $year = $yearPrefix . $matches[2];
        $month = $matches[3];
        $day = $matches[4];

        if( !checkdate($month, $day, $year) ) {
            return false;
        }

        return $this->checkSum($value);
    }
}
