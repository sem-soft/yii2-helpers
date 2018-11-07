<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace sem\helpers;

/**
 * Предоставляет статические полезные методы для работы с массивами
 */
class ArrayHelper extends \yii\helpers\ArrayHelper
{

    /**
     * Производит поиск объекта по значению его поля в массиве объектов
     * 
     * @param string $attribute имя атрибута, по которому ведется поиск
     * @param mixed $needle значение атрибута для поиска
     * @param \Object[] $haystack массив объектов, в котором ведется поиск
     * @return \Object|false|NULL если объект найден, то он будет возвращен, в случае возникновения ошибки будет возвращаен false
     */
    public static function searchObject($attribute, $needle, $haystack)
    {
        foreach ($haystack as $i => $object) {

            if (!is_object($object)) {
                return false;
            }

            if (!isset($object->$attribute)) {
                return false;
            }

            if ($object->$attribute == $needle) {
                return $object;
            }
        }

        return null;
    }
}
