<?php


namespace Liaosp\Tool\Arrays;


class ArrayHelper
{
    /**
     * 全局替换
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
