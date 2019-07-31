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

    /**
     * @desc 得到某天凌晨零点的时间戳
     * @param string $str
     * @return int
     */
    public static function getSomeZeroTimeStamp($str='today'){
        switch ($str)
        {
            case 'today':   // 今天凌晨零点的时间戳
                return strtotime(date("Y-m-d"),time());
                break;
            case 'yesterday':   // 昨天 即 今天凌晨零点的时间戳 减去 一天的秒数
                return strtotime(date("Y-m-d"),time())-3600*24;
                break;
            case 'tomorrow':    // 明天 即 今天凌晨零点的时间戳 加上 一天的秒数
                return strtotime(date("Y-m-d"),time())+3600*24;
                break;
            case 'month_first': // 这个月第一天凌晨零点的时间戳
                return strtotime(date("Y-m"),time());
                break;
            case 'year_first':  // 这一年第一天凌晨零点的时间戳
                return strtotime(date("Y-01"),time());
                break;
            default:   // 默认为今天凌晨零点的时间戳
                return strtotime(date("Y-m-d"),time());
        }
    }
    /**
     * @desc 友好时间显示
     * @param $time
     * @return bool|string
     */
   public static function friendDate($time)
    {
        if (!$time)
            return false;
        $f_date = '';
        $d = time() - intval($time);
        $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
        $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
        $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
        $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
        $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
        $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
        $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
        if ($d == 0) {
            $f_date = '刚刚';
        } else {
            switch ($d) {
                case $d < $atd:
                    $f_date = date('Y年m月d日', $time);
                    break;
                case $d < $td:
                    $f_date = '后天' . date('H:i', $time);
                    break;
                case $d < 0:
                    $f_date = '明天' . date('H:i', $time);
                    break;
                case $d < 60:
                    $f_date = $d . '秒前';
                    break;
                case $d < 3600:
                    $f_date = floor($d / 60) . '分钟前';
                    break;
                case $d < $dd:
                    $f_date = floor($d / 3600) . '小时前';
                    break;
                case $d < $yd:
                    $f_date = '昨天' . date('H:i', $time);
                    break;
                case $d < $byd:
                    $f_date = '前天' . date('H:i', $time);
                    break;
                case $d < $md:
                    $f_date = date('m月d日 H:i', $time);
                    break;
                case $d < $ld:
                    $f_date = date('m月d日', $time);
                    break;
                default:
                    $f_date = date('Y年m月d日', $time);
                    break;
            }
        }
        return $f_date;
    }
    /**
     * @desc 获取当前时间的前7天
     * @return array
     */
    public static function  getLast7Days(){
        $begin = strtotime(date('Y-m-d', strtotime('-6 days')));  // ? 7天前
        $today_time = strtotime(date('Y-m-d'));  // ? 7天前
        $now_time = time();
        $weeks_arr = array();
        $weeks_arr['date'] = array();
        $weeks_arr['weeks'] = array();
        $weeks_arr['day'] = array();
        $weeks_array = array("日","一","二","三","四","五","六"); // 先定义一个数组
        $day_second = 3600*24;
        for ($i = $begin; $i < $now_time; $i = $i + $day_second){
            if($i != $today_time){
                array_push($weeks_arr['date'], $i);
            }else{
                array_push($weeks_arr['date'], $now_time);
            }
            array_push($weeks_arr['weeks'], '星期'.$weeks_array[date('w', $i)]);
            array_push($weeks_arr['day'], date('Y-m-d', $i));
        }
        return $weeks_arr;
    }
    /**
     * 格式化计数时间
     * @param $timestamp
     * @return string
     */
    public static function tranCountTimeFormat($timestamp)
    {
        $str = '';

        if ($timestamp % 60 != 0) {
            $str = $timestamp % 60 . '秒';
        }
        if ($timestamp % 3600 != 0 && ($timestamp % 3600) / 60 > 1) {
            $str = (int)(($timestamp % 3600) / 60) . '分钟' . $str;
        }
        if ($timestamp % (3600 * 24) != 0 && ($timestamp % (3600 * 24)) / 3600 > 1) {
            $str = (int)(($timestamp % (3600 * 24)) / 3600) . '小时' . $str;
        }
        if ($timestamp % (3600 * 24 * 30) != 0 && ($timestamp % (3600 * 24 * 30)) / (3600 * 24) > 1) {
            $str = (int)(($timestamp % (3600 * 24 * 30)) / (3600 * 24)) . '天' . $str;
        }
        if ($timestamp % (3600 * 24 * 365) != 0 && ($timestamp % (3600 * 24 * 365)) / (3600 * 24 * 30) > 1) {
            $str = (int)(($timestamp % (3600 * 24 * 365)) / (3600 * 24 * 30)) . '月' . $str;
        }
        if ($timestamp > 3600 * 24 * 365) {
            $str = (int)($timestamp / (3600 * 24 * 365)) . '年' . $str;
        }
        return $str;
    }




}
