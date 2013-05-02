<?php

namespace SPE\HungarianValidatorBundle\Validator;

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
 * Az Y helyen igen ritkan elofordulhat 0, amikor a cegbirosag mar kiadta az
 * adoszamot, de hibas vagy felfuggesztett bejelentkezes miatt az adozo meg
 * nincs bejegyezve a cegnyilvantartasba. (Ez tehat csak elo-tarsasagi
 * idoszakban fordulhat elo.)
 *
 * http://www.partnercontrol.hu/default.asp?page=tudastar&gyp=3
 */
class VatNumberValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        [0-9]{8}                                   # torzsszam
        [\- ]?
        [0-5]                                      # afa kod
        [\- ]?
        (?:51|4[0-4]|3[0-9]|2[02-9]|1[0-9]|0[2-9]) # terulet azonosito
        $
        /x';
}
