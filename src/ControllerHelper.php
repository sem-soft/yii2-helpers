<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace sem\helpers;

use yii\web\NotFoundHttpException;

/**
 * Предоставляет статические полезные методы,
 * облегчающие работу с данными контроллера
 */
class ControllerHelper
{

    /**
     * Производит загрузку ActiveRecord-модели по уникальному идентификатору
     * 
     * @param string $className наименование класса модели в пространстве имен
     * @param integer $id уникальный идентификатор искомой модели к загрузке
     * @param string $errMessage сообщение об ошибке, в случае если модель не найдена
     * @return \yii\db\ActiveRecord найденный экземпляр модели
     * @throws NotFoundHttpException
     */
    public static function loadModel($className, $id, $errMessage)
    {
        if (($model = $className::findOne($id)) !== null) {

            return $model;
        }

        throw new NotFoundHttpException($errMessage);
    }
}
