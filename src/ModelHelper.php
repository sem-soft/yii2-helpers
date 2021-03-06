<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers;

/**
 * Предоставляет статические полезные методы,
 * облегчающие работу с данными AR-моделей и форм
 */
class ModelHelper
{
    
    /**
     * Возвращает текст первой ошибки из всех ошибок валидации полей модели,
     * либо false в случае если ошибок валидации нет
     * 
     * @param \yii\base\Model $model
     * @return string 
     */
    public static function firstErrorText(\yii\base\Model $model)
    {
        if ($model->hasErrors()) {
            $errors = $model->firstErrors;
            return array_shift($errors);
        }
        
        return false;
    }
}
