<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers;

/**
 * Предоставляет статические методы для работы с данными HTTP-запроса
 */
class RequestHelper
{
    
    /**
     * Возвращает IP-адрес клиентского запроса
     *
     * @return string|null
     */
    public static function getUserIp()
    {
        $ipHeaders = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipHeaders as $ipHeader){
            if (array_key_exists($ipHeader, $_SERVER) === true){

                foreach (explode(',', $_SERVER[$ipHeader]) as $ip){

                    $ip = trim($ip);

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }

                }

            }
        }

        return null;
    }
}
