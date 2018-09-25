<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers\string;

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
    const MOBILE_PHONE_MIN_LENGHT = 11;

    /**
     * Производит нормализацию 11-значного номера телефона:
     * если первая его цифра отличается от $prefix, то она заменяется на $prefix.
     * Либо если длина номера телефона 12 сиволов и первые два символа +X, то они заменяются на $prefix.
     *
     * @param string $number номер телефона в виде строки
     * @param string $prefix телефонный префикс
     * @return false|string
     * @todo пересмотреть и сделать возможность использования универсального префикса - высчитывать его длину и т.д.
     */
    public static function normalize($phone, $prefix = '8')
    {

        $phone = preg_replace("/[^0-9+]/", "", $phone);

        if (mb_strlen($phone, 'UTF-8') > self::MOBILE_PHONE_MAX_LENGHT || mb_strlen($phone, 'UTF-8') < self::MOBILE_PHONE_MIN_LENGHT) {
            return false;
        }

        if (mb_strlen($phone, 'UTF-8') == self::MOBILE_PHONE_MAX_LENGHT && mb_substr($phone, 0, 1, 'UTF-8') == '+') {
            return $prefix . mb_substr($phone, 2, null, 'UTF-8');
        }

        if (mb_substr($phone, 0, 1, 'UTF-8') != $prefix) {

            if (mb_strlen($phone, 'UTF-8') == 11) {
                return $prefix . mb_substr($phone, 1, null, 'UTF-8');
            } else {
                return $prefix . $phone;
            }

        } else {
            return $phone;
        }

    }

    /**
     * Преобразует телефонный номер к читабельному виду по маске: (XXX) XXX-XX-XX
     *
     * @param string $phone сплошная последовательность цифр, например 8632216827
     * @param string $codeTag HTML-тег, в который заворачивается код города
     * @param string $phoneTag HTML-тег, в который заворачивается номер телефона
     * @param array $codeTagOptions массив с дополнительными атрибутами для HTML-тега $codeTag
     * @return string красивый номер, например (863) 221-68-27
     */
    public static function format($phone, $codeTag = 'span', $phoneTag = '', $codeTagOptions = [])
    {
        $codePattern = '($2)';
        $numberPattern = ' $3-$4-$5';

        if ($codeTag) {
            $tagOptions = '';
            if (!empty($codeTagOptions)) {
                foreach ($codeTagOptions as $attribute => $value)
                    $tagOptions .= ' ' . $attribute . '="' . Html::encode($value) . '"';
            }
            $codePattern = '<' . $codeTag . $tagOptions . '>' . $codePattern . '</' . $codeTag . '>';
        }

        if ($phoneTag)
            $numberPattern = '<' . $phoneTag . '>' . $numberPattern . '</' . $phoneTag . '>';

        return preg_replace('/(\d*)(\d{3})(\d{3})(\d{2})(\d{2})$/', $codePattern . $numberPattern, $phone);
    }
}