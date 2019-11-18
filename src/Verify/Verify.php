<?php


namespace Liaosp\Tool\Verify;


class Verify
{
    /**
     * @desc 判断是否为合法的ip地址
     * @param string $ip ip地址
     * @return bool|int 不合法则返回false，合法则返回4（IPV4）或6（IPV6）
     */
    public static function isIPAddress($ip)
    {
        $ipv4Regex = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/';
        $ipv6Regex = '/^(((?=.*(::))(?!.*\3.+\3))\3?|([\dA-F]{1,4}(\3|:\b|$)|\2))(?4){5}((?4){2}|(((2[0-4]|1\d|[1-9])?\d|25[0-5])\.?\b){4})$/i';
        if (preg_match($ipv4Regex, $ip))
            return 4;
        if (false !== strpos($ip, ':') && preg_match($ipv6Regex, trim($ip, ' []')))
            return 6;
        return false;
    }
    /**
     * @desc 验证邮箱格式
     * @param $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        $check = false;
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $check = true;
        }
        return $check;
    }
    /**
     * @desc 判断是否为手机访问
     * @return  boolean
     */
   public static function isMobile() {
        $sp_is_mobile = false;
        if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
            $sp_is_mobile = false;
        } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            $sp_is_mobile = true;
        } else {
            $sp_is_mobile = false;
        }
        return $sp_is_mobile;
    }
    /**
     * @desc 判断是否为微信访问
     * @return boolean
     */
    public static function isWeiXin(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }
    /**
     * @desc 检查手机号码格式
     * @param $mobile 手机号码
     */
    public static  function checkMobile($mobile){
        if(preg_match('/1[0123456789]\d{9}$/',$mobile))
            return true;
        return false;
    }
    /**
     * @desc 检查固定电话
     * @param $mobile
     * @return bool
     */
    public static  function checkTelephone($mobile){
        if(preg_match('/^([0-9]{3,4}-)?[0-9]{7,8}$/',$mobile))
            return true;
        return false;
    }
    /**
     * @desc 当前请求是否是https
     * @return type
     */
    public static function isHttps()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off';
    }


    /**
     * 判断数据是否为空
     * @param null $var          要判断的值
     * @param bool $zeroIsEmpty  0是否也判断为空：true-判断为空（默认），false-判断不为空
     * @return bool
     */
    public static function isEmpty($var = null, $zeroIsEmpty = true)
    {
        // 判断数据类型
        switch ( gettype($var) ) {
            case 'integer':
                return $zeroIsEmpty
                    ? (0 == $var ? true : false)             // ‘0’认为是空
                    : (0 != $var && !$var ? true : false);   // ‘0’不认为是空
                break;
            case 'string':
                return (0 == strlen($var)) ? true : false;
                break;
            case 'array':
                return (0 == count($var)) ? true : false;
                break;
            case 'boolean':
                return $var ? false : true;
                break;
            default:
                return true;
                break;
        }
    }

}
