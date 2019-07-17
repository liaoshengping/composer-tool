<?php


namespace Liaosp\Tool\Time;


class Time
{
    /**
     * 获取毫秒
     * @return float
     */
    public static function millisecond() {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }
}
