## 时间：

```
获取毫秒：Time::millisecond()
```
## 字符：

中文转化为英文首字母
```
Character::getEnByCnByString('我是中国人',2)  //return  WS

String::utf8_strlen('我是中国ren')

```
## 抓取微信公众号文章

```
include ("vendor/autoload.php");
$obj = new \Liaosp\Tool\Spider\Wechat\WxCrawler();
$data =$obj->crawByUrl('https://mp.weixin.qq.com/s?timestamp=1563437558&src=3&ver=1&signature=FIUv1dgs8cmQWLd3A1OlV5x3Ln5Nmz8b5zOQw9*WuwQdXmJolSxfDZku2UW6-vsiBIA5GfaTS1NR6fEN8*6ubmySiAStgwqQ-vkfYZR9igI6KtgjOEHZPEyNk98nNjaoguA0v0tBkT4z76-ye1cEnzaJuhgYc9WAPVxiw-y32z4=');
echo ($data['content_html']);
```
>可以爬取成功，但是图片不能显示
```
//先爬图片到服务器，再输出 或者 可以把图片图片保存在服务器上，替换url，这时你需要继承WxCrawler进行改写contentHandle方法
//爬取之前设置
//$obj->setAntiLeech('fangpa.php?url=');
```
fangpa.php
```
<?php
header('Content-type: image/jpg');
$url = $_GET['url'];
$refer = "http://www.qq.comsss/";
$opt = [
    'http'=>[
        'header'=>"Referer: " . $refer
    ]
];
$context = stream_context_create($opt);
$file_contents = file_get_contents($url);
echo $file_contents;
```


