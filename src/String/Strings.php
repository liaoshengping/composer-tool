<?php


namespace Liaosp\Tool\String;


class Strings
{
    /**
     * 获取中文长度
     * @param null $string
     * @return int
     */
    public static function utf8_strlen($string = null) {
// 将字符串分解为单元
        preg_match_all("/./us", $string, $match);
// 返回单元个数
        return count($match[0]);
    }
}
