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
     * @param string $method метод отправки данных формы
     * @return array
     */
    public static function prepareRequestData($formName, $method = 'post')
    {
        $result = [];

        $method = mb_strtolower($method, 'UTF-8');
        
        if ($method != 'get') {
            $method = 'post';
        }
        
        if ($data = Yii::$app->request->$method()) {
            $result[$formName] = $data;
        }

        return $result;
    }
    
    /**
     * Возвращает IP-адрес клиентского запроса
     *
     * @return string|null
     */
    public static function getUserIp()
    {
        $userIp = null;
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $userIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $userIp = $_SERVER['REMOTE_ADDR'];
        }
        
        if ($userIp) {
            $userIp = trim(explode(',', $userIp)[0]);
        }
        
        return $userIp;
    }
}
