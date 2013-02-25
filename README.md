# Installálás

composer.json fájlba:
```
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/loonkwil/extra-validator.git"
    },
    ...
],
"require": {
    ...
    "spe/extra-validator": "dev-master",
    ...
}
```

```
php composer.phar update
```

# Használata

```php
<?php
namespace Acme\AcmeDemoBundle\Entity;

use SPE\ExtraValidatorBundle\Validator as ExtraAssert;

class AcmeEntity {
  /**
   * @ExtraAssert\PersonalId(message="Hibás személyi szám")
   */
  protected $personal_id;

  ...
}
```
