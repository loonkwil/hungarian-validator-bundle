# Hungarian Validator Bundle

[![Build Status](https://travis-ci.org/loonkwil/hungarian-validator-bundle.png)](https://travis-ci.org/loonkwil/hungarian-validator-bundle)

## Installálás

composer.json fájlba:
```json
{
  "repositories": [
      {
          "type": "vcs",
          "url": "https://github.com/loonkwil/hungarian-validator-bundle.git"
      },
  ],
  "require": {
      "spe/hungarian-validator-bundle": "dev-master",
  }
}
```

```bash
php composer.phar update
```

## Használata

```php
<?php
namespace Acme\AcmeDemoBundle\Entity;

use SPE\HungarianValidatorBundle\Validator as HungarianAssert;

class AcmeEntity {
  /**
   * @HungarianAssert\PersonalId(message="Hibás személyi szám")
   */
  protected $personal_id;

  // ...
}
```

## Elérhető validátorok

 * Irányítószám (ZipCode)
 * Adószám (VatNumber)
 * Adóazonosító jel (TaxId)
 * Személyi szám (PersonalId)
 * Személyazonosító igazolvány (kártya) szám (IdCardNumber)
 * Teljes név (FullName)
 * Cégjegyzékszám (BusinessRegistrationNumber)
