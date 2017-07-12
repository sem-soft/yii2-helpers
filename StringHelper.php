<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace sem\helpers;

use \yii\helpers\Html;

/**
 * Предоставляет статические полезные методы для работы со строками или текстом
 */
class StringHelper
{

    /**
     * Производит транслитерацию строки из кириллицы в US-ANSI
     * 
     * @param string $string строка для транслитерации
     * @param bool $forUrl признак транслитерации строки для использования в URL
     * @param char $replaceSymbol на какой символ заменять спец. символы при транслитерации
     * @return string
     */
    public static function transliterate($string, $forUrl = false, $replaceSymbol = '-')
    {

        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];
        if ($forUrl) {
            $converter['ь'] = '';
            $converter['ъ'] = '';
            $converter['Ь'] = '';
            $converter['Ъ'] = '';
            $converter[' '] = $replaceSymbol;
            $converter['_'] = $replaceSymbol;
            $converter['`'] = $replaceSymbol;
            $converter['~'] = $replaceSymbol;
            $converter['!'] = $replaceSymbol;
            $converter['@'] = $replaceSymbol;
            $converter['#'] = $replaceSymbol;
            $converter['$'] = $replaceSymbol;
            $converter['%'] = $replaceSymbol;
            $converter['^'] = $replaceSymbol;
            $converter['&'] = $replaceSymbol;
            $converter['*'] = $replaceSymbol;
            $converter['('] = $replaceSymbol;
            $converter[')'] = $replaceSymbol;
            $converter['-'] = $replaceSymbol;
            $converter['='] = $replaceSymbol;
            $converter['+'] = $replaceSymbol;
            $converter['['] = $replaceSymbol;
            $converter[']'] = $replaceSymbol;
            $converter['\\'] = $replaceSymbol;
            $converter['|'] = $replaceSymbol;
            $converter['/'] = $replaceSymbol;
            $converter[','] = $replaceSymbol;
            $converter['{'] = $replaceSymbol;
            $converter['\''] = $replaceSymbol;
            $converter['"'] = $replaceSymbol;
            $converter[';'] = $replaceSymbol;
            $converter[':'] = $replaceSymbol;
            $converter['?'] = $replaceSymbol;
            $converter['<'] = $replaceSymbol;
            $converter['>'] = $replaceSymbol;
            $converter['№'] = $replaceSymbol;
        }

        $string = !$forUrl ? strtr($string, $converter) : mb_strtolower(strtr($string, $converter), 'UTF-8');

        return trim(preg_replace("/$replaceSymbol{2,}/", $replaceSymbol, $string), $replaceSymbol);
    }

    /**
     * Разбивает строку по словам
     * 
     * @param string $text строка
     * @return array массив слов
     */
    public static function splitByWords($text)
    {
        $matches = [];
        preg_match_all('/[^\W\d][\w]*/iu', $text, $matches, PREG_PATTERN_ORDER);
        return !empty($matches) ? $matches[0] : [];
    }

    /**
     * Производит нормализацию 11-значного номера телефона:
     * если первая его цифра отличается от $prefixNumber, то она заменяется на $prefixNumber.
     * Либо если длина номера телефона 12 сиволов и первые два символа +X, то они заменяются на $prefixNumber.
     * 
     * @param string $phoneNumber
     * @return string|false
     */
    public static function normalizePhone($phoneNumber, $prefixNumber = '8')
    {

        $phoneNumber = preg_replace("/[^0-9+]/", "", $phoneNumber);

        if (mb_strlen($phoneNumber, 'UTF-8') > 12 || mb_strlen($phoneNumber, 'UTF-8') < 11) {
            return false;
        }

        if (mb_strlen($phoneNumber, 'UTF-8') == 12 && mb_substr($phoneNumber, 0, 1, 'UTF-8') == '+') {
            return $prefixNumber . mb_substr($phoneNumber, 2, null, 'UTF-8');
        }

        if (mb_substr($phoneNumber, 0, 1, 'UTF-8') != $prefixNumber) {

            if (mb_strlen($phoneNumber, 'UTF-8') == 11) {
                return $prefixNumber . mb_substr($phoneNumber, 1, null, 'UTF-8');
            } else {
                return $prefixNumber . $phoneNumber;
            }
        } else {
            return $phoneNumber;
        }

        return false;
    }

    /**
     * Преобразует телефонный номер к читабельному виду по маске: (XXX) XXX-XX-XX
     * 
     * @param string $phoneNumber сплошная последовательность цифр, например 8632216827
     * @param string $codeTag HTML-тег, в который заворачивается код города
     * @param string $phoneTag HTML-тег, в который заворачивается номер телефона
     * @param array $codeTagOptions массив с дополнительными атрибутами для HTML-тега $codeTag
     * @return @return string красивый номер, например (863) 221-68-27
     */
    public static function formatPhone($phoneNumber, $codeTag = 'span', $phoneTag = '', $codeTagOptions = [])
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

        return preg_replace('/(\d*)(\d{3})(\d{3})(\d{2})(\d{2})$/', $codePattern . $numberPattern, $phoneNumber);
    }

    /**
     * Форматирует десятичное число к ценовому виду с двумя знаками после зяпятой по следующему правилу:
     * если дробная часть отсутсвует, то вернет целое число;
     * если количество знаков дробной части меньше $precision, то вернет десятичное число, у которого дробная часть дополнена нулями до $precision
     * 
     * @param decimal $price цена в виде десятичного числа
     * @return string форматированная цена
     */
    public static function formatPrice($price, $precision = 2)
    {
        if (($delimPos = strpos($price, '.')) !== false) {
            $price = substr($price, 0, $delimPos) . '.' . str_pad(substr($price, $delimPos + 1), $precision, "0");
        }
        return $price;
    }

    /**
     * Производит мультибайтовую замену подстрок
     * 
     * @param string $needle что ищем
     * @param string $replacement на что меняем
     * @param string $haystack где ищем
     * @return string
     */
    public static function mbStrReplace($needle, $replacement, $haystack)
    {
        $needle_len = mb_strlen($needle);
        $replacement_len = mb_strlen($replacement);
        $pos = mb_strpos($haystack, $needle);

        while ($pos !== false) {
            $haystack = mb_substr($haystack, 0, $pos) . $replacement
                . mb_substr($haystack, $pos + $needle_len);
            $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
        }

        return $haystack;
    }

    /**
     * Производит отчистку строки от HTML
     * @param string $value
     * @return string
     */
    public static function cleanFromHtml($value)
    {
        return Html::encode(strip_tags($value));
    }
    
    /**
     * Удаляет символы расширенной кодировки utf8mb4 из utf8-строки
     * 
     * @param string $string
     * @param bool $trim производить ли удаление повторяющихся пробелов и табуляций
     * @return string
     */
    public static function rmUtf8Multibite($string, $trim = true)
    {
        $result = preg_replace('%(?:
              \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )%xs', '', $string);
        
        if ($trim) {
            $result = self::rmMultipleSpaces($result);
        }
        
        return $result;
    }
    
    /**
     * Производит замену в строке идущих подряд более одного раза поробелов
     * @param string $string
     * @return string
     */
    public static function rmMultipleSpaces($string)
    {
        return preg_replace('/\s\s+/', ' ', $string);
    }
}
