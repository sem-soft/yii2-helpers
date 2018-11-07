<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2018-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\helpers;

/**
 * Предоставляет статические полезные методы для работы с объектами фаловой системы
 */
class FileHelper extends \yii\helpers\FileHelper
{

    /**
     * Единица измерени Гигобайт
     */
    const UNIT_SIZE_GB = "GB";

    /**
     * Единица измерения Мегабайт
     */
    const UNIT_SIZE_MB = "MB";

    /**
     * Единица измерения Килобайт
     */
    const UNIT_SIZE_KB = "KB";

    /**
     * Единица измерения байты
     */
    const UNIT_SIZE_BITE = "bytes";

    /**
     * Форматирует размер файла исходя их его "веса" в байтах.
     * Если принудительно задана единица измерения, то в нее будет выполнен перевод.
     * 
     * @param integer $size размер файла в байтах
     * @param string $unit единица измерения
     * @param bool $withUnit выводить с указанием единицы измерения или нет
     * @return string
     */
    public static function formatSize($size, $unit = false, $withUnit = true)
    {
        if ((!$unit && $size >= 1 << 30) || $unit == self::UNIT_SIZE_GB) {
            return number_format($size / (1 << 30), 2) . ($withUnit ? " " . self::UNIT_SIZE_GB : "");
        }

        if ((!$unit && $size >= 1 << 20) || $unit == self::UNIT_SIZE_MB) {
            return number_format($size / (1 << 20), 2) . ($withUnit ? " " . self::UNIT_SIZE_MB : "");
        }

        if ((!$unit && $size >= 1 << 10) || $unit == self::UNIT_SIZE_KB) {
            return number_format($size / (1 << 10), 2) . ($withUnit ? " " . self::UNIT_SIZE_KB : "");
        }

        return number_format($size) . ($withUnit ? " " . self::UNIT_SIZE_BITE : "");
    }


    /**
     * Автоматически определяет максимально допустимый размер возможного загружаемого файла в байтах
     * @return integer
     */
    public static function getMaxUploadSize()
    {
        $uploadMaxFileSize = self::sizeInBytes(ini_get('upload_max_filesize'));
        $postMaxSize = self::sizeInBytes(ini_get('post_max_size'));

        $limits[] = $uploadMaxFileSize;

        if ($postMaxSize > 0) {
            $limits[] = $postMaxSize;
        }

        return (int) min($limits);
    }

    /**
     * Возвращает количество памяти в байтах.
     *
     * @param string $value количество памяти в отличной от байт единице измерения и задданое как в php.ini (например, 2G, 20M, 1024K)
     * @return int
     */
    public static function sizeInBytes($value)
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value)-1]);

        switch($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }

        return (int) $value;
    }
}
