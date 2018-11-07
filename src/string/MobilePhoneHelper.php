<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers\string;

use Yii;
use sem\helpers\Html;

/**
 * Хелпер для работы с номерами мобильных телефонов РФ
 */
class MobilePhoneHelper
{

    /**
     * Максимальная длина номера телефона с учетом префикса
     */
    const MOBILE_PHONE_MAX_LENGHT = 12;

    /**
     * Минимальная длина номера телефона без учета префикса
     */
    const MOBILE_PHONE_MIN_LENGHT = 10;

    /**
     * Производит нормализацию мобильного номера телефона,
     * выделяя из $phone возможные символы номера телефона и подставляя префикс,
     * если он отсутствует или требует замены на новый.
     * Например,
     * ```php
     * echo MobilePhoneHelper::normalize('+ (903) 111-22-33', '+7') . "<br>"; // +79031112233
     * echo MobilePhoneHelper::normalize('+7 903 111-22-33', '+7') . "<br>"; // +79031112233
     * echo MobilePhoneHelper::normalize('+8 (903) 111-22-33', '+7') . "<br>"; // +79031112233
     * echo MobilePhoneHelper::normalize('9031112233', '+7') . "<br>"; // +79031112233
     * echo MobilePhoneHelper::normalize('+9031112233', '8') . "<br>"; // 89031112233
     * echo MobilePhoneHelper::normalize('+7 (903) 111-22-33', '8') . "<br>"; // 89031112233
     * echo MobilePhoneHelper::normalize('+8 (903) 111-22-33', '8') . "<br>"; // 89031112233
     * echo MobilePhoneHelper::normalize('(903) 111-22-33', '8') . "<br>"; // 89031112233
     * ```
     * @param string $phone номер телефона в виде строки
     * @param string $prefix телефонный префикс
     * @param null $encoding кодировка
     * @return false|string
     */
    public static function normalize($phone, $prefix = '+7', $encoding = null)
    {
        $phone = preg_replace("/[^0-9+]/ui", "", $phone);

        if ($encoding === null) {
            $encoding = Yii::$app->charset;
        }

        $phoneLen = mb_strlen($phone, $encoding);

        if ($phoneLen > self::MOBILE_PHONE_MAX_LENGHT || $phoneLen < self::MOBILE_PHONE_MIN_LENGHT) {
            return false;
        }

        // Добавляем префик с последним self::MOBILE_PHONE_MIN_LENGHT строки
        return $prefix . mb_substr($phone, -self::MOBILE_PHONE_MIN_LENGHT, null, $encoding);
    }

    /**
     * Форматирует номер мобильного телефона к выводу в HTML.
     * Например,
     * ```php
     * echo MobilePhoneHelper::format(MobilePhoneHelper::normalize('+ (903) 111-22-33', '+7'), true) . "<br>"; // +7 (903) 470-68-34
     * echo MobilePhoneHelper::format(MobilePhoneHelper::normalize('+9031112233', '8'), true) . "<br>"; // 8 (903) 470-68-34
     * ```
     * @param string $phone сплошная последовательность цифр, например 8632216827 или +79031112233
     * @param bool $withPrefix включать префикс номера (+7 или 8) в общий вывод
     * @param string $codeTag HTML-тег, в который заворачивается код города
     * @param string $phoneTag HTML-тег, в который заворачивается номер телефона
     * @param array $codeTagOptions массив с дополнительными атрибутами для HTML-тега $codeTag
     * @return string красивый номер, например (863) 221-68-27
     */
    public static function format($phone, $withPrefix = false, $codeTag = 'span', $phoneTag = '', $codeTagOptions = [])
    {
        $codePattern = '($2)';
        $numberPattern = ' $3-$4-$5';

        if ($codeTag) {
            $tagOptions = '';
            if (!empty($codeTagOptions)) {
                foreach ($codeTagOptions as $attribute => $value) {
                    $tagOptions .= ' ' . $attribute . '="' . Html::encode($value) . '"';
                }
            }
            $codePattern = '<' . $codeTag . $tagOptions . '>' . $codePattern . '</' . $codeTag . '>';
        }

        if ($phoneTag) {
            $numberPattern = '<' . $phoneTag . '>' . $numberPattern . '</' . $phoneTag . '>';
        }

        $format = ($withPrefix ? '$1 ' : '') . $codePattern . $numberPattern;

        return preg_replace('/([\d+]*)(\d{3})(\d{3})(\d{2})(\d{2})$/', $format, $phone);
    }
}