<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;

if (!function_exists('isCurrentRoute')) {
    /**
     * @param string $name
     * @param array $parameters
     * @return string|null
     */
    function isCurrentRoute(string $name, array $parameters = [])
    {
        // get queries with parameters
        return url()->full() === route($name, $parameters) ? 'active' : null;
    }
}
if (!function_exists('cart')) {
    /**
     * @return bool
     */
    function cart()
    {
        return session()->has('orderId') ? true : false;
    }
}
if (!function_exists('numberFormat')) {
    /**
     * @param integer|float $price
     * @param null|string $unit
     * @return string
     */
    function numberFormat($price, $unit = null): string
    {
        $value = number_format($price, 2, '.', ' ');
        $value = str_replace('.00', '', $value);

        if (!is_null($unit)) {
            $value .= ' ' . $unit;
        }
        return $value;
    }
}
if (!function_exists('parseDate')) {
    /**
     * @param string $str
     * @return Date
     */
    function parseDate($str)
    {

        return Jenssegers\Date\Date::parse($str);
    }
}
if (!function_exists('limitMonth')) {
    /**
     * @param $str
     * @return string
     */
    function limitMonth($str)
    {
        $arr1 = explode(' ', $str);
        $n = mb_strlen($arr1[1], 'utf-8');
        if ($n > 3) {
            return $arr1[0] . ' ' . Str::limit($arr1[1], 3, '.');
        }
        return $str;
    }
}
if (!function_exists('fileExist')) {
    /**
     * @param string $name
     * @return string
     */
    function fileExist($name): string
    {
        setlocale(LC_ALL, 'ru_RU.utf8');
        $info = pathinfo($name);
        if (!empty($info['extension'])) {
            // if the file already contains an extension returns it
            return $name;
        }
        $filename = $info['filename'];
        $len = strlen($filename);
        // open the folder
        $dh = opendir($info['dirname']);
        if (!$dh) {
            return false;
        }
        // scan each file in the folder
        while (($file = readdir($dh)) !== false) {
            if (($file == ".") || ($file == "..")) {
                continue;
            }
            if (strncmp($file, $filename, $len) === 0) {
                if (strlen($name) > $len) {
                    // if name contains a directory part
                    $name = substr($name, 0, strlen($name) - $len) . $file;
                } else {
                    // if the name is at the path root
                    $name = $file;
                }
                closedir($dh);
                return asset($name);
            }
        }
        // file not found
        closedir($dh);
        return asset('images/nophoto.png');
    }
}
if (!function_exists('getIdsFromCollect')) {
    /**
     * @param $collect
     * @return array
     */
    function getIdsFromCollect($collect): array
    {
        return $collect->map(static function ($item) {
            return $item->id;
        })->toArray();
    }
}
/**
 * проверяем, что функция mb_ucfirst не объявлена
 * и включено расширение mbstring (Multibyte String Functions)
 */
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}
