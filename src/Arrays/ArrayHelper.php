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


    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }

        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }
}
