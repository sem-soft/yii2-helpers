<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers\string;

/**
 * Расширяет функционал базового @see \yii\helpers\StringHelper
 */
class StringHelper extends \yii\helpers\StringHelper
{

    /**
     * Производит замену в строке идущих подряд более одного раза поробелов
     * @param string $value
     * @return string
     */
    public static function rmMultipleSpaces($value)
    {
        return preg_replace('/\s\s+/', ' ', $value);
    }

}