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

    /**
     * 未来几天的隔离时间
     * 13：30
     * 14：00
     * 14：30
     */
    public static function getIsolationTime($day = 7, $minute = 30, $nowMsg = '立即购买')
    {
        $selectTime = array();
        $nowTime = time();
        for ($i = 1; $i <= $day; $i++) {
            if ($i != 1) {
                $nowTime = strtotime(date('Y-m-d', strtotime('+'.($i-1).' day')));
            }
            //离明天结束还有多少个30分钟
            $isolation = $minute * 60;
            $tomorrow = strtotime( date('Y-m-d',strtotime("+1day",$nowTime)));
            $todayAllTime = $tomorrow - $nowTime;
            $nums = intval($todayAllTime / $isolation);
            $subArray = [];
            for ($b = 1; $b <= $nums; $b++) {
                $tomorrow = $tomorrow - $isolation;
                $subArray[] = [
                    'time' => $tomorrow,
                    'formatTime' => date("H:i", $tomorrow),
                ];
            }
            if($i ==1){
                $subArray[] = [
                    'time' => $nowTime,
                    'formatTime' => $nowMsg . '(约' . date('H:i') . ')',
                ];
            }
            $subArray = array_reverse($subArray);
            $selectTime[] = [
                'date'=>date('m月d日', $nowTime),
                'data'=>$subArray,
            ];

            continue;
        }
        return $selectTime;
    }

    /**
     * 都是时间戳
     * 返回两个时间的相距时间，*年*月*日*时*分*秒
     * @param int $one_time 时间一
     * @param int $two_time 时间二
     * @param int $return_type 默认值为0，0/不为0则拼接返回，1/*秒，2/*分*秒，3/*时*分*秒/，4/*日*时*分*秒，5/*月*日*时*分*秒，6/*年*月*日*时*分*秒
     * @param array $format_array 格式化字符，例，array('年', '月', '日', '时', '分', '秒')
     * @return String or false
     */
    public static function getRemainderTime($one_time, $two_time, $return_type=0, $format_array=array('年', '月', '日', '时', '分', '秒'))
    {
        if ($return_type < 0 || $return_type > 6) {
            return false;
        }


        if (!(is_int($one_time) && is_int($two_time))) {
            return false;
        }
        $remainder_seconds = abs($one_time - $two_time);
        //年
        $years = 0;
        if (($return_type == 0 || $return_type == 6) && $remainder_seconds - 31536000 > 0) {
            $years = floor($remainder_seconds / (31536000));
        }
        //月
        $monthes = 0;
        if (($return_type == 0 || $return_type >= 5) && $remainder_seconds - $years * 31536000 - 2592000 > 0) {
            $monthes = floor(($remainder_seconds - $years * 31536000) / (2592000));
        }
        //日
        $days = 0;
        if (($return_type == 0 || $return_type >= 4) && $remainder_seconds - $years * 31536000 - $monthes * 2592000 - 86400 > 0) {
            $days = floor(($remainder_seconds - $years * 31536000 - $monthes * 2592000) / (86400));
        }
        //时
        $hours = 0;
        if (($return_type == 0 || $return_type >= 3) && $remainder_seconds - $years * 31536000 - $monthes * 2592000 - $days * 86400 - 3600 > 0) {
            $hours = floor(($remainder_seconds - $years * 31536000 - $monthes * 2592000 - $days * 86400) / 3600);
        }
        //分
        $minutes = 0;
        if (($return_type == 0 || $return_type >= 2) && $remainder_seconds - $years * 31536000 - $monthes * 2592000 - $days * 86400 - $hours * 3600 - 60 > 0) {
            $minutes = floor(($remainder_seconds - $years * 31536000 - $monthes * 2592000 - $days * 86400 - $hours * 3600) / 60);
        }
        //秒
        $seconds = $remainder_seconds - $years * 31536000 - $monthes * 2592000 - $days * 86400 - $hours * 3600 - $minutes * 60;
        $return = false;
        switch ($return_type) {
            case 0:
                if ($years > 0) {
                    $return = $years . $format_array[0] . $monthes . $format_array[1] . $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                } else if ($monthes > 0) {
                    $return = $monthes . $format_array[1] . $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                } else if ($days > 0) {
                    $return = $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                } else if ($hours > 0) {
                    $return = $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                } else if ($minutes > 0) {
                    $return = $minutes . $format_array[4] . $seconds . $format_array[5];
                } else {
                    $return = $seconds . $format_array[5];
                }
                break;
            case 1:
                $return = $seconds . $format_array[5];
                break;
            case 2:
                $return = $minutes . $format_array[4] . $seconds . $format_array[5];
                break;
            case 3:
                $return = $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                break;
            case 4:
                $return = $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                break;
            case 5:
                $return = $monthes . $format_array[1] . $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                break;
            case 6:
                $return = $years . $format_array[0] . $monthes . $format_array[1] . $days . $format_array[2] . $hours . $format_array[3] . $minutes . $format_array[4] . $seconds . $format_array[5];
                break;
            default:
                $return = false;
        }
        return $return;
    }




}
