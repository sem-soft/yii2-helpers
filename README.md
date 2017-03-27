# Set of additional basic helpers for Yii2 Framework
## Install by composer
composer require sem-soft/yii2-helpers
## Or add this code into require section of your composer.json and then call composer update in console
"sem-soft/yii2-helpers": "*"
## Usage
```php
<?php
  $text = 'Привет, Земляне! Я - Марсианин!';
  echo sem\helpers\StringHelper::transliterate($text, true);

  print_r(sem\helpers\StringHelper::splitByWords($text));

  $phone = '9031234567';
  echo sem\helpers\StringHelper::normalizePhone($phone);

  $phone = '89031234567';
  echo sem\helpers\StringHelper::formatPhone($phone);
 ?>
 ```
