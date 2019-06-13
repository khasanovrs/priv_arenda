<?php
/**
 * Вспомогательные функции
 */

namespace app\components\helper;

use Yii;

class helperClass
{
    /**
     * Рандомное значение
     * @param $length
     * @return string
     */

    public static function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}