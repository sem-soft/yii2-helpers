<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace sem\helpers;

/**
 * Предоставляет статические полезные методы,
 * связанные с обесчечением безопасности данных и кода web-приложения
 */
class SecurityHelper
{

    /**
     * Производит отчистку поданной на вход строки от возможных XSS-внедрений
     * @param string $string строка, подлежащая очистки
     * @return string
     */
    public static function xssClean($string)
    {

        if (trim($string) === '') {
            return $string;
        }

        // xss_clean function from Kohana framework 2.3.4
        $string = str_replace(['&amp;', '&lt;', '&gt;'], ['&amp;amp;', '&amp;lt;', '&amp;gt;'], $string);
        $string = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $string);
        $string = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $string);
        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $string = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $string);
        // Remove javascript: and vbscript: protocols
        $string = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $string);
        $string = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $string);
        $string = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $string);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $string);
        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $string);
        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $string);
        // Remove namespaced elements (we do not need them)
        $string = preg_replace('#</*\w+:\w[^>]*+>#i', '', $string);

        do {
            // Remove really unwanted tags
            $old_data = $string;
            $string = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $string);
        } while ($old_data !== $string);

        return $string;
    }

    /**
     * Генерирует псевдослучайную числовую строку указанной дины
     * 
     * @param integer $length длина генерируемой строки
     * @return string полученная строка
     */
    public static function generateRandomNumberString($length = 6)
    {
        $result = '';

        for ($index = 0; $index < $length; $index++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }
}
