<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers\string;

/**
 * Хелпер для работы со значениями стоимостных показателей
 */
class CostHelper
{

    /**
     * Форматирует десятичное число к ценовому виду с двумя знаками после зяпятой по следующему правилу:
     * если дробная часть отсутсвует, то вернет целое число;
     * если количество знаков дробной части меньше $precision, то вернет десятичное число, у которого дробная часть дополнена нулями до $precision
     *
     * @param string|float $cost стоимость
     * @param int $precision точность дробной части
     * @return string форматированная цена
     * @todo сравнить функционал с существующим https://www.yiiframework.com/doc/api/2.0/yii-i18n-formatter. Понять как оптимизировать, либо избавиться.
     */
    public static function format($cost, $precision = 2)
    {
        if (($delimPos = strpos($cost, '.')) !== false) {
            $cost = substr($cost, 0, $delimPos) . '.' . str_pad(substr($cost, $delimPos + 1), $precision, "0");
        }

        return $cost;
    }
}