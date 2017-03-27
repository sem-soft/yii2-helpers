<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace sem\helpers;

use yii\helpers\FileHelper as ParentFileHelper;

/**
 * Предоставляет статические полезные методы для работы с объектами фаловой системы
 */
class FileHelper extends ParentFileHelper
{
    /**
     * Метод отдает поданный на вход файл браузеру
     * @param string $filepath полный путь к файлу
     */
    public static function toStream($filepath)
    {
	
	if (ob_get_level()) {
	    ob_end_clean();
	}
	
	// заставляем браузер показать окно сохранения файла
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . basename($filepath));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($filepath));
	
	// читаем файл и отправляем его пользователю
	echo file_get_contents($filepath);
	die();
	
    }
}
