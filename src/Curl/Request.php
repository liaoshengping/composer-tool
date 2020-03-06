<?php


namespace Liaosp\Tool\Curl;


class Request
{
    public static  function curlRequest($base_url, $query_data, $method = 'get', $ssl = true, $exe_timeout = 10, $conn_timeout = 10, $dns_timeout = 3600)
    {
        $ch = curl_init();

        if ( $method == 'get' ) {
            //method get
            if ( ( !empty($query_data) )
                && ( is_array($query_data) )
            ){
                $connect_symbol = (strpos($base_url, '?')) ? '&' : '?';
                foreach($query_data as $key => $val) {
                    if ( is_array($val) ) {
                        $val = serialize($val);
                    }
                    $base_url .= $connect_symbol . $key . '=' . rawurlencode($val);
                    $connect_symbol = '&';
                }
            }
        } else {
            if ( ( !empty($query_data) )
                && ( is_array($query_data) )
            ){
                foreach($query_data as $key => $val) {
                    if ( is_array($val) ) {
                        $query_data[$key] = serialize($val);
                    }
                }
            }
            //method post
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_data);
        }
        curl_setopt($ch, CURLOPT_URL, $base_url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $conn_timeout);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, $dns_timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $exe_timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 关闭ssl验证
        if($ssl){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $output = curl_exec($ch);

        if ( $output === FALSE )
            $output = '';

        curl_close($ch);
        return $output;
    }
}
