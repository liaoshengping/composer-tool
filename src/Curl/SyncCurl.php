<?php


namespace Liaosp\Tool\Curl;


class SyncCurl
{
    /**
     * 异步请求网络，回调处理获取的参数
     *
    $urls = [];
    for ($i=0;$i<100;$i++){
    $urls[] ='http://baidu.com';
    }


    function callback($output){
    echo $output;
    }

    rolling_curl($urls,'callback');

     * @param $urls
     * @param $callback
     * @param null $custom_options
     * @return bool
     */
    public static function Curl($urls, $callback, $custom_options = null)
    {//多个url访问

// make sure the rolling window isn't greater than the # of urls
        $rolling_window = 5;
        $rolling_window = (sizeof($urls) < $rolling_window) ? sizeof($urls) : $rolling_window;

        $master = curl_multi_init();
        $curl_arr = array();

// add additional curl options here
        $std_options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5
        );
        $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;

// start the first batch of requests
        for ($i = 0; $i < $rolling_window; $i++) {
            $ch = curl_init();
            $options[CURLOPT_URL] = $urls[$i];
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($master, $ch);
        }

        do {
            while (($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM) ;
            if ($execrun != CURLM_OK) {
                break;
            }

// a request was just completed -- find out which one
            while ($done = curl_multi_info_read($master)) {
                $info = curl_getinfo($done['handle']);
                if ($info['http_code'] == 200) {
                    $output = curl_multi_getcontent($done['handle']);

// request successful.  process output using the callback function.
                    $callback($output);

// start a new request (it's important to do this before removing the old one)
// 当$i等于$urls数组大小时不用再增加了
                    if ($i < sizeof($urls)) {
                        $ch = curl_init();
                        $options[CURLOPT_URL] = $urls[$i++]; // increment i
                        curl_setopt_array($ch, $options);
                        curl_multi_add_handle($master, $ch);
                    }
// remove the curl handle that just completed
                    curl_multi_remove_handle($master, $done['handle']);
                } else {
// request failed.  add error handling.
                }
            }
        } while ($running);

        curl_multi_close($master);
        return true;
    }
}
