<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers;

/**
 * Расширяем функциональность стандартного @see \yii\helpers\Html
 */
class Html extends \yii\helpers\Html
{
    /**
     * Выделяет "чистый" текст путем удаления html-тегов
     *
     * @param string $value
     * @return string
     */
    public static function purgeText($value)
    {
        return Html::encode(strip_tags($value));
    }
}