<?php

namespace SPE\ExtraValidatorBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxIdValidator extends ConstraintValidator
{
    // Csak a 1921-10-05 es 2031-04-10 kozotti datumokat fogadja el!
    protected $pattern = '/^(8)[\- ]?([2-5][0-9]{4})[\- ]?([0-9]{3})[\- ]?([0-9])$/';

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

        $ret = $this->checkTaxId($value);

        if( !$ret ) {
            $this->setMessage($constraint->message);
        }

        return $ret;
    }

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
     *  - a 10. szamjegy az 1–9. szamjegyek felhasznalasaval matematikai
     *    modszerekkel kepzett ellenorzo szam.
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
    private function checkTaxId($value)
    {
        if( preg_match($this->pattern, $value, $matches) === 0 ) {
            return false;
        }

        $withoutSeparators = '';
        for( $i = 1; $i < count($matches); ++$i ) {
            $withoutSeparators .= $matches[$i];
        }

        $sum = 0;
        for( $i = 0; $i < 9; ++$i ) {
            $sum += (int)$withoutSeparators[$i] * ($i + 1);
        }

        return ($sum % 11) === (int)$matches[4];
    }
}
