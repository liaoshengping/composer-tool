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

    /**
     * 二位数组排序
     * @param $array
     * @param $keys
     * @param string $sort
     * @return array
     */
    public static function arraySort($array, $keys, $sort = 'asc')
    {
        $newArr = $valArr = array();
        foreach ($array as $key => $value) {
            $valArr[$key] = $value[$keys];
        }
        ($sort == 'asc') ? asort($valArr) : arsort($valArr);
        reset($valArr);
        foreach ($valArr as $key => $value) {
            $newArr[$key] = $array[$key];
        }
        return $newArr;
    }
}
