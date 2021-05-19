<?php

namespace Liaosp\Tool\Url;

class UrlTool
{

    /**
     * 获取顶级域名或者指定几级域名
     */
    public static function getTopHost($url, $level = 1)
    {

        $url = strtolower($url);  //首先转成小写
        $hosts = parse_url($url);
        $host = $hosts['host'];
        //查看是几级域名
        $data = explode('.', $host);
        $n = count($data);
        //判断是否是双后缀
        $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
        if (($n > 2) && preg_match($preg, $host)) {
            //双后缀取后3位
            $host = $data[$n - 3] . '.' . $data[$n - 2] . '.' . $data[$n - 1];
        } else {
            //默认取一级域名
            $host = '';
            for ($i = $level + 1; $i > 0; $i--) {
                if (empty($data[$n - $i])) continue;
                $host .= $data[$n - $i];
                if ($i != 1) $host .= '.';
            }
        }
        return $host;
    }
}
