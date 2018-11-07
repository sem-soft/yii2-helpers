<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers\string;

/**
 * Хелпер для работы с мульбибайтовыми строками
 */
class MultibyteStringHelper
{

    /**
     * Метод производит замену подстроки в строке
     *
     * @param string $needle искомая строка для замены
     * @param string $replacement заменять на
     * @param string $haystack строка, в которой производится замена
     *
     * @param null|string $encoding мультибайтовая кодировка
     *
     * @return string новая строка
     */
    public static function strReplace($needle, $replacement, $haystack, $encoding = null)
    {
        if ($encoding == null) {
            $encoding = \Yii::$app->charset;
        }

        $needle_len = mb_strlen($needle, $encoding);
        $replacement_len = mb_strlen($replacement, $encoding);

        $pos = mb_strpos($haystack, $needle, 0, $encoding);
        while ($pos !== false) {
            $haystack = mb_substr($haystack, 0, $pos, $encoding) . $replacement
                . mb_substr($haystack, $pos + $needle_len, null, $encoding);
            $pos = mb_strpos($haystack, $needle, $pos + $replacement_len, $encoding);
        }

        return $haystack;
    }

    /**
     * Производит удаление расширенных UTF-8 символов более 2-х (utf8mb4).
     * Также, если разрешен trim, заменяет символы-разделители приемлемыми символами @see self::replaceExtendedSeparators.
     * @param $value
     * @param bool $trim
     * @return null|string|string[]
     */
    public static function rmExtendedSymbols($value, $trim = true)
    {
        $value = preg_replace('%(?:
              \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )%xs', '', $value);

        if ($trim) {
            $value = StringHelper::rmMultipleSpaces($value);
            $value = self::replaceExtendedSeparators($value);
        }

        return $value;
    }

    /**
     * Заменяет расширенные символы-разделители строк на приемлемые
     *
     * @param string|array $value
     * @param array $separators
     * @return null|string|string[]
     */
    public static function replaceExtendedSeparators($value, $separators = [
        "\xe2\x80\xa8" => '\n',
        "\xe2\x80\xa9" => '\t'
    ]) {

        $needle = array_keys($separators);
        $replacement = array_values($separators);

        return preg_replace($needle, $replacement, $value);
    }
}