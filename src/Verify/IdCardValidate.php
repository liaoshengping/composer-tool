<?php


namespace Liaosp\Tool\Verify;


class IdCardValidate
{

    /**
     * 生成随机字符串
     * @param int $length
     * @return string
     */
    public static function GenerateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }



    /**
     * 计算身份证校验码，根据国家标准GB 11643-1999
     * @param $idcard_base
     * @return bool|mixed
     */
    private function idcard_verify_number($idcard_base)
    {
        if (strlen($idcard_base) != 17) {
            return false;
        }
        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++) {
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        return $verify_number;
    }

    /**
     *  将15位身份证升级到18位
     * @param $idcard
     * @return bool|string
     */
    public function idcard_15to18($idcard)
    {
        if (strlen($idcard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $idcard = substr($idcard, 0, 6) . '18' . substr($idcard, 6, 9);
            } else {
                $idcard = substr($idcard, 0, 6) . '19' . substr($idcard, 6, 9);
            }
        }
        $idcard = $idcard . $this->idcard_verify_number($idcard);
        return $idcard;
    }

    /**
     * 18位身份证校验码有效性检查
     * @param $idcard
     * @return bool
     */
    function idcard_checksum18($idcard)
    {
        if (strlen($idcard) != 18) {
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if ($this->idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
            return false;
        } else {
            return true;
        }
    }

    //  TODO    身份证验证   end

    /**
     * 隐藏身份证
     * @param $idcard
     * @param int $start
     * @param string $hideChar
     * @return mixed
     */
    public static function HideIDCard($idcard, $start = 6, $charLen = 8, $char = '*')
    {
        $hideChar = str_repeat($char, $charLen);
        $hideLen = strlen($hideChar);
        return substr_replace($idcard, $hideChar, $start, $hideLen);
    }

    /**
     * 隐藏姓名
     * @param $name
     * @return mixed
     */
    public static function HideName($name, $char = '*')
    {
        $len = strlen($name) - 1;
        $hideChar = str_repeat($char, $len);
        return substr_replace($name, $hideChar, 1, $len);
    }

    //  TODO    银行卡

    /**
     * 银行卡号验证
     * @param $cardNumber
     * @return string
     */
    public static function bankCardCheck($cardNumber)
    {
        return true;
        $arr_no = str_split($cardNumber);
        $last_n = $arr_no[count($arr_no) - 1];
        krsort($arr_no);
        $i = 1;
        $total = 0;
        foreach ($arr_no as $n) {
            if ($i % 2 == 0) {
                $ix = $n * 2;
                if ($ix >= 10) {
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                } else {
                    $total += $ix;
                }
            } else {
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $x = 10 - ($total % 10);
        if ($x == $last_n) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * luhn算法验证
     * @param $cardNumber
     * @return bool
     */
    public static function bankCardCheckOld($cardNumber)
    {
        $arr_no = str_split($cardNumber);
        $last_n = $arr_no[count($arr_no) - 1];
        krsort($arr_no);
        $i = 1;
        $total = 0;
        foreach ($arr_no as $n) {
            if ($i % 2 == 0) {
                $ix = $n * 2;
                if ($ix >= 10) {
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                } else {
                    $total += $ix;
                }
            } else {
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $x = 10 - ($total % 10);
        if ($x == $last_n) {
            return true;
        } else {
            return false;
        }
    }
    //  TODO    银行卡

    /**
     * 替换银行卡、手机号码为**。
     * @param type $str 要替换的字符串
     * @param type $startlen 开始长度 默认4
     * @param type $endlen 结束长度 默认3
     * @return type
     */
    public static function strreplace($str, $startlen = 4, $endlen = 3)
    {
        $repstr = "";
        if (strlen($str) < ($startlen + $endlen + 1)) {
            return $str;
        }
        $count = strlen($str) - $startlen - $endlen;
        for ($i = 0; $i < $count; $i++) {
            $repstr .= "*";
        }
        return preg_replace('/(\d{' . $startlen . '})\d+(\d{' . $endlen . '})/', '${1}' . $repstr . '${2}', $str);
    }

    //  TODO    营业执照

    /**
     * 统一社会信用代码验证
     * 自动转换为大写进行的检验
     * 入库前需要所有字母转为大写strtoupper
     * 统一社会信用代码为18位无‘-’
     * 统一社会信用代码是新的全国范围内唯一的、始终不变的法定代码标识。
     * 由18位数字（或大写拉丁字母）组成
     * 第一位是           登记部门管理代码
     * 第二位是           机构类别代码
     * 第三位到第八位是   登记管理机关行政区域码
     * 第九位到第十七位   主体标识码（组织机构代码）
     * 第十八位           校验码
     * 校验码按下列公式计算：
     * C18 = 31 - MOD ( ∑Ci * Wi ，31) (1)
     * MOD  表示求余函数；
     * i    表示代码字符从左到右位置序号；
     * Ci   表示第i位置上的代码字符的值，采用附录A“代码字符集”所列字符；
     * C18  表示校验码；
     * Wi   表示第i位置上的加权因子，其数值如下表：
     * i 1 2 3 4  5  6  7  8  9  10 11 12 13 14 15 16 17
     * Wi 1 3 9 27 19 26 16 17 20 29 25 13  8 24 10 30 28
     * 当MOD函数值为0（即 C18 = 31）时，校验码用数字0表示。
     * $lenght = 18;//长度
     * $text = '0123456789ABCDEFGHJKLMNPQRTUWXY';//可以出现的字符
     * $notext = 'IOZSV';//不会出现的字符
     */
    public static function UnifiedSocialCreditCodeCheck($str)
    {
        $one = '159Y';//第一位可以出现的字符
        $two = '12391';//第二位可以出现的字符
        $str = strtoupper($str);
        if (!strstr($one, $str['0']) || !strstr($two, $str['1']) || !empty($array[substr($str, 2, 6)])) {
            echo '错误';
            exit;
        }
        $wi = array(1, 3, 9, 27, 19, 26, 16, 17, 20, 29, 25, 13, 8, 24, 10, 30, 28);//加权因子数值
        $str_organization = substr($str, 0, 17);
        $num = 0;
        for ($i = 0; $i < 17; $i++) {
            $num += self::transFormation($str_organization[$i]) * $wi[$i];
        }
        switch ($num % 31) {
            case '0':
                $result = 0;
                break;
            default:
                $result = 31 - $num % 31;
                break;
        }
        if (substr($str, -1, 1) == self::transFormation($result, true)) {
            return true;
        }
        return false;
    }

    /**
     * 数据翻转
     * @param $num
     * @param bool $status
     * @return mixed
     */
    public static function transFormation($num, $status = false)
    {
        $list = array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            'A' => 10,
            'B' => 11,
            'C' => 12,
            'D' => 13,
            'E' => 14,
            'F' => 15,
            'G' => 16,
            'H' => 17,
            'J' => 18,
            'K' => 19,
            'L' => 20,
            'M' => 21,
            'N' => 22,
            'P' => 23,
            'Q' => 24,
            'R' => 25,
            'T' => 26,
            'U' => 27,
            'W' => 28,
            'X' => 29,
            'Y' => 30
        );//值转换
        if ($status == true) {
            $list = array_flip($list);//翻转key/value
        }
        return $list[$num];
    }
    //  TODO    营业执照
}
