<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers;

use Yii;

/**
 * Предоставляет статические полезные методы для работы с данными HTTP-запроса
 */
class RequestHelper
{
    
    /**
     * Подготавливает информацию из запроса для использования в методе @see \yii\db\ActiveRecord::load()
     * 
     * @param string $formName @see \yii\db\ActiveRecord::formName()
     * @return array
     */
    public static function prepareRequestData($formName)
    {
	$result = [];
	
	if ($data = Yii::$app->request->post()) {
	    $result[$formName] = $data;
	}
	
	return $result;
    }
}
