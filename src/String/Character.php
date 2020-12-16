<?php


namespace Liaosp\Tool\String;


class  Character
{
    /**
     * @param $string
     * @param int $length 转化的长度
     *
     * @return bool|string
     */
    public static function getEnByCnByString($string, $length = 10)
    {
        if (empty($string)) {
            return false;
        }
        preg_match_all("/./u", $string, $arr);
        $exp = $arr[0];
        if (empty($exp)) {
            return false;
        }
        $sum = 1;
        $res = '';
        foreach ($exp as $key => $value) {
            $cha = self::getFirstCharter($value);
            $res .= $cha;
            if (!empty($cha)) {
                $sum++;
            }
            if ($sum > $length) {
                return $res;
            }
        }
        return $res;
    }

    /**
     * 转化中文为字母的工具
     * @param $str
     * @return null|string
     */
    public static function getFirstCharter($str)
    {
        if (is_numeric($str)) {
            return '';
        }
        if (empty($str)) {
            return '';
        }

        $fchar = ord($str[0]);

        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str[0]);

        $s1 = iconv('UTF-8', 'gb2312', $str);

        $s2 = iconv('gb2312', 'UTF-8', $s1);

        $s = $s2 == $str ? $s1 : $str;

        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;

        if ($asc >= -20319 && $asc <= -20284)
            return 'A';

        if ($asc >= -20283 && $asc <= -19776)
            return 'B';

        if ($asc >= -19775 && $asc <= -19219)
            return 'C';

        if ($asc >= -19218 && $asc <= -18711)
            return 'D';

        if ($asc >= -18710 && $asc <= -18527)
            return 'E';

        if ($asc >= -18526 && $asc <= -18240)
            return 'F';

        if ($asc >= -18239 && $asc <= -17923)
            return 'G';

        if ($asc >= -17922 && $asc <= -17418)
            return 'H';

        if ($asc >= -17417 && $asc <= -16475)
            return 'J';

        if ($asc >= -16474 && $asc <= -16213)
            return 'K';

        if ($asc >= -16212 && $asc <= -15641)
            return 'L';

        if ($asc >= -15640 && $asc <= -15166)
            return 'M';

        if ($asc >= -15165 && $asc <= -14923)
            return 'N';

        if ($asc >= -14922 && $asc <= -14915)
            return 'O';

        if ($asc >= -14914 && $asc <= -14631)
            return 'P';

        if ($asc >= -14630 && $asc <= -14150)
            return 'Q';

        if ($asc >= -14149 && $asc <= -14091)
            return 'R';

        if ($asc >= -14090 && $asc <= -13319)
            return 'S';

        if ($asc >= -13318 && $asc <= -12839)
            return 'T';

        if ($asc >= -12838 && $asc <= -12557)
            return 'W';

        if ($asc >= -12556 && $asc <= -11848)
            return 'X';

        if ($asc >= -11847 && $asc <= -11056)
            return 'Y';

        if ($asc >= -11055 && $asc <= -10247)
            return 'Z';

        return null;

    }

    /**
     * 下划线转化后面为大写
     * user_id
     * ucfirst ==true  第一个为大写 ： UserId
     * ucfirst ==false 第一个为小写 ： userId
     * @param $str
     * @param bool $ucfirst
     * @return mixed|string
     */
    public static function convertUnderline($str, $ucfirst = true)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

    /**
     * 下划线转化为大写字母
     * @param $name
     * @return string
     */
    function convertUnderlineToLetter($name)
    {
        $temp_array = array();
        for ($i = 0; $i < strlen($name); $i++) {
            $ascii_code = ord($name[$i]);
            if ($ascii_code >= 65 && $ascii_code <= 90) {
                if ($i == 0) {
                    $temp_array[] = chr($ascii_code + 32);
                } else {
                    $temp_array[] = '_' . chr($ascii_code + 32);
                }
            } else {
                $temp_array[] = $name[$i];
            }
        }
        return implode('', $temp_array);
    }

    /**
     * 大写转化为下划线
     * @param $str
     * @return string
     */
    public static function capital_to_underline($str)
    {
        $temp_array = array();
        for ($i = 0; $i < strlen($str); $i++) {
            $ascii_code = ord($str[$i]);
            if ($ascii_code >= 65 && $ascii_code <= 90) {
                if ($i == 0) {
                    $temp_array[] = chr($ascii_code + 32);
                } else {
                    $temp_array[] = '_' . chr($ascii_code + 32);
                }
            } else {
                $temp_array[] = $str[$i];
            }
        }
        return implode('', $temp_array);
    }


}
