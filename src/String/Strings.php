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

    /**
     * @desc 字符串截取，支持中文和其他编码, 字符串截取是一个开发者都要面对的基本技能，毕竟你要处理数据，支持中文和其他编码
     * @desc 这里的关键，$charset="utf-8"，对中文支持是很重要的！不然出现一些？号，就要挨批了！
     * @param [string] $str  [字符串]
     * @param integer $start [起始位置]
     * @param integer $length [截取长度]
     * @param string $charset [字符串编码]
     * @param boolean $suffix [是否有省略号]
     * @return [type] [description]
     */
    public static function mSubStr($str, $start=0, $length=15, $charset="utf-8", $suffix=true) {
        if(function_exists("mb_substr")) {
            return mb_substr($str, $start, $length, $charset);
        } elseif(function_exists('iconv_substr')) {
            return iconv_substr($str,$start,$length,$charset);
        }
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
        if($suffix) {
            return $slice."…";
        }
        return $slice;
    }
    /*
    使用方法如下：
        echo mSubStr($str, $start=0, $length=15, $charset="utf-8", $suffix=true)
    */

    /**
     *  * 生成uuid
     *  * @return string
     *  */
    public static function createUuid()
    {
        $hexChar = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];
        date_default_timezone_set('PRC');
        $mTimestamp = sprintf("%.3f", microtime(true));
        $mTimestampStr = str_replace(".", "", $mTimestamp);

        $key = "A" . strtoupper(base_convert($mTimestampStr, 10,  16));

        for ($i = 0; $i < 20; $i++) {
            $key .= $hexChar[rand(0, 15)];
        }

        return $key;
    }

    /**
     * 是否包含https
     * @param $url
     */
    public static function isHttpOrHttps($url){
        $preg = "/^http(s)?:\\/\\/.+/";
        if(preg_match($preg,$url))
        {
            return true;
        }else
        {
            return false;
        }
    }
}
