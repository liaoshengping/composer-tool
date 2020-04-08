<?php


namespace Liaosp\Tool\Arrays;


class ArrayHelper
{
    /**
     * 全局替换多维数组  模版消息替换见PHPNOTE：https://github.com/liaoshengping/phpNote/blob/master/array/%E5%A4%9A%E7%BB%B4%E6%95%B0%E7%BB%84%E6%AD%A3%E5%88%99%E6%9B%BF%E6%8D%A2.php
     * @param $array
     * @param string $search
     * @param string $replace
     */
    public static function arrayReplace(&$array, $search='', $replace='') {
        $array = str_replace($search, $replace, $array);
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    self::arrayReplace($array[$key],$search,$replace);
                }
            }
        }
    }
}
