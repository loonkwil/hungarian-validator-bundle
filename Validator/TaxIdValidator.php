<?php

namespace SPE\HungarianValidatorBundle\Validator;

/**
 * adoazonosito jel ellenorzese
 *
 * Az adoazonosito szamot a torveny szerint az alabbiak szerint kell kepezni:
 *  - az 1. szamjegy konstans 8-as szam, mely az adoalany maganszemely voltara
 *    utal
 *  - a 2–6. szamjegyek a szemely szuletesi idopontja es az 1867. januar 1.
 *    kozott eltelt napok szama (vagyis 1900. januar 1-jetol a szuletesi
 *    idopontig eltelt napok szama + 12 051)
 *  - a 7–9. szamjegyek az azonos napon szuletettek megkulonboztetesere szolgalo
 *    veletlenszeruen kepzett sorszam,
 *  - a 10. szamjegy az 1–9. szamjegyek felhasznalasaval matematikai modszerekkel
 *    kepzett ellenorzo szam.
 *  - Az adoazonosito jel tizedik szamjegyet ugy kell kepezni, hogy az elso
 *    szamjegyek mindegyiket szorozni kell azzal a sorszammal, ahanyadik helyet
 *    foglalja el az azonositon belul. (Elso szamjegy szorozva eggyel, masodik
 *    szamjegy szorozva kettovel es igy tovabb.) Az igy kapott szorzatok
 *    osszeget el kell osztani 11-gyel, es az osztas maradeka a tizedik
 *    szamjeggyel lesz egyenlo. A 7–9. szamjegyek szerinti szuletesi sorszam nem
 *    adhato ki, ha a 11-gyel valo osztas maradeka egyenlo tizzel.
 *
 * http://hu.wikipedia.org/wiki/Ad%C3%B3azonos%C3%ADt%C3%B3_jel
 */
class TaxIdValidator extends HungarianValidator
{
    // Csak a 1921-10-05 es 2031-04-10 kozotti datumokat fogadja el!
    protected $pattern = '/
        ^
        8
        [\- ]?
        [2-5][0-9]{4} # 20000-59999, ezert, csak a fent elmitett ket datum kozott
                      # szuletetteket fogadja el
        [\- ]?
        [0-9]{3}
        [\- ]?
        [0-9]         # ellenorzo szam
        $
        /x';

    protected function check($value)
    {
        if( preg_match($this->pattern, $value) === 0 ) {
            return false;
        }

        return $this->checkSum($value);
    }
}
