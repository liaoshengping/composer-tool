## 时间：

```
获取毫秒：Time::millisecond()

得到某天凌晨零点的时间戳 Time::getSomeZeroTimeStamp('today')
友好时间显示 比如 刚刚，前一分钟，前一天 Time::friendDate(23423232423)
获取前七天的信息 Time::getLast7Days()
请在   1.2天 完成订单Time::tranCountTimeFormat(时间戳)
```
## 字符：

中文转化为英文首字母
```
Character::getEnByCnByString('我是中国人',2)  //return  WS
截取字符串，防止中文乱码？？  String::mSubStr()
user_id 转化为大写： UserId 或 userId  Character::convertUnderline('user_id',false)
UserId =》 user_id大写字母转化为下划线Character::convertUnderlineToLetter
```
## 验证
```
判断是否为合法的ip地址 Verify::isIPAddress
是否为邮箱    Verify::isValidEmail
Shi为手机     Verify::isMobile
是否https    Verify::isHttps
```
## 文件
```
下载网络图片到本地：NetFile::getImage($url, $save_dir='', $filename='', $type=0);
移动文件夹，查看文件夹大小，文件夹管理：File::...
```
## 获取中文字符长度
```
String::utf8_strlen('我是中国ren') // 7
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


