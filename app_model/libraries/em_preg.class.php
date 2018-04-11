<?php

class em_preg
{
    /**
     * 匹配手机号码
     * 规则：
     * 手机号码基本格式：
     * 前面三位为：
     * 移动：134-139 147 150-152 157-159 182 187 188
     * 联通：130-132 155-156 185 186
     * 电信：133 153 180 189
     * 后面八位为：
     * 0-9位的数字
     */
    public static function pregPN($str_preg)
    {
        $rule = "/^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/A";
        preg_match($rule, $str_preg, $result);
        return $result;
    }

    /**
     * 匹配邮箱
     * 规则：
     * 邮箱基本格式是 *****@**.**
     * @以前是一个 大小写的字母或者数字开头，紧跟0到多个大小写字母或者数字或 .
     * _ - 的字符串
     * @之后到.之前是 1到多个大小写字母或者数字的字符串
     * .之后是 1到多个 大小写字母或者数字或者.的字符串
     */
    public static function pregE($str_preg)
    {
        $zhengze = '/^[a-zA-Z0-9][a-zA-Z0-9._-]*\@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/A';
        preg_match($zhengze, $str_preg, $result);
        return $result;
    }


    /**
     * 电话号码匹配
     * 电话号码规则：
     * 区号：3到5位，大部分都是四位，北京(010)和上海市(021)三位，西藏有部分五位，可以包裹在括号内也可以没有
     * 如果有区号由括号包裹，则在区号和号码之间可以有0到1个空格，如果区号没有由括号包裹，则区号和号码之间可以有两位长度的 或者-
     * 号码：7到8位的数字
     * 例如：(010) 12345678 或者 (010)12345678 或者 010 12345678 或者 010--12345678
     */
    public static function pregTP($str_preg)
    {
        $rule = '/^(((010)|(021)|(0\d3,4))( ?)([0-9]{7,8}))|((010|021|0\d{3,4}))([- ]{1,2})([0-9]{7,8})$/A';
        preg_match($rule, $str_preg, $result);
        return $result;
    }

    /**
     * 匹配url
     * url规则：
     * 例
     * 协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名
     * http://zhidao.baidu.com/question/535596723.html
     * 协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名?参数
     * www.lhrb.com.cn/portal.php?mod=view&aid=7412
     * 协议://域名（www/tieba/baike...）.名称.后缀/文件路径/文件名/参数
     * http://www.xugou.com.cn/yiji/erji/index.php/canshu/11
     *
     * 协议：可有可无，由大小写字母组成；不写协议则不应存在://，否则必须存在://
     * 域名：必须存在，由大小写字母组成
     * 名称：必须存在，字母数字汉字
     * 后缀：必须存在，大小写字母和.组成
     * 文件路径：可有可无，由大小写字母和数字组成
     * 文件名：可有可无，由大小写字母和数字组成
     * 参数:可有可无，存在则必须由?开头，即存在?开头就必须有相应的参数信息
     */
    public static function pregURL($str_preg)
    {
        $rule = '/^(([a-zA-Z]+)(:\/\/))?([a-zA-Z]+)\.(\w+)\.([\w.]+)(\/([\w]+)\/?)*(\/[a-zA-Z0-9]+\.(\w+))*(\/([\w]+)\/?)*(\?(\w+=?[\w]*))*((&?\w+=?[\w]*))*$/';
        preg_match($rule, $str_preg, $result);
        return $result;
    }


    /**
     * 匹配身份证号
     * 规则：
     * 15位纯数字或者18位纯数字或者17位数字加一位x
     */
    public static function pregIC($str_preg)
    {
        $rule = '/^(([0-9]{15})|([0-9]{18})|([0-9]{17}x))$/';
        preg_match($rule, $str_preg, $result);
        return $result;
    }


    /**
     * 匹配邮编
     * 规则：六位数字，第一位不能为0
     */
    public static function pregPOS($str_preg)
    {
        $rule = '/^[1-9]\d{5}$/';
        preg_match($rule, $str_preg, $result);
        return $result;
    }


    /**
     * 匹配ip
     * 规则：
     * *1.**2.**3.**4
     * *1可以是一位的 1-9，两位的01-99，三位的001-255
     * *2和**3可以是一位的0-9，两位的00-99,三位的000-255
     * *4可以是一位的 1-9，两位的01-99，三位的001-255
     * 四个参数必须存在
     */
    public static function pregIP($str_preg)
    {
        $rule = '/^((([1-9])|((0[1-9])|([1-9][0-9]))|((00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))))\.)((([0-9]{1,2})|(([0-1][0-9]{2})|(2[0-4][0-9])|(25[0-5])))\.){2}(([1-9])|((0[1-9])|([1-9][0-9]))|(00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5])))$/';
        preg_match($rule, $str_preg, $result);
        return $result;
    }


    /**
     * 匹配时间
     * 规则：
     * 形式可以为：
     * 年-月-日 小时:分钟:秒
     * 年-月-日 小时:分钟
     * 年-月-日
     * 年：1或2开头的四位数
     * 月：1位1到9的数；0或1开头的两位数，0开头的时候个位数是1到9的数，1开头的时候个位数是1到2的数
     * 日：1位1到9的数；0或1或2或3开头的两位数，0开头的时候个位数是1到9的数，1或2开头的时候个位数是0到9的数，3开头的时候个位数是0或1
     * 小时：0到9的一位数；0或1开头的两位数，个位是0到9；2开头的两位数，个位是0-3
     * 分钟：0到9的一位数；0到5开头的两位数，个位是0到9；
     * 分钟：0到9的一位数；0到5开头的两位数，各位是0到9
     */
    public static function pregTI($str_preg)
    {
        $rule = '/^(([1-2][0-9]{3}-)((([1-9])|(0[1-9])|(1[0-2]))-)((([1-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))))( ((([0-9])|(([0-1][0-9])|(2[0-3]))):(([0-9])|([0-5][0-9]))(:(([0-9])|([0-5][0-9])))?))?$/';
        preg_match($rule, $str_preg, $result);
        return $result;
    }

    public static function pregCh($str_preg)
    {
        // utf8下匹配中文
        $rule = '/([\x{4e00}-\x{9fa5}]){1}/u';
        preg_match_all($rule, $str_preg, $result);
        return $result;
    }
    
    public static function preg_date_time($str_preg,$date_model='datetime')
    {
//         $rule = '/^(\d{4}-(((0(1|3|5|7|8))|(1(0|2)))(-((0[1-9])|([1-2][0-9])|(3[0-1])))?)|(((0(2|4|6|9))|(11))(-((0[1-9])|([1-2][0-9])|(30)))?)|((02)(-((0[1-9])|(1[0-9])|(2[0-8])))?))|(((([0-9]{2})((0[48])|([2468][048])|([13579][26]))|(((0[48])|([2468][048])|([3579][26]))00)))-02-29)$/';
        $rule = '/^[1-2][0-9]{3}-((0([1-9]{1}))|(1[1|2]))-(([0-2]([1-9]{1}))|(3[0|1]))\s([0-1][0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]$/';
        switch ($date_model)
        {
            case 'year':
                $rule = '/^[1-2][0-9]{3}$/';
                break;
            case 'time':
                $rule = '/^([0-1][0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]$/';
                break;
            case 'date':
                $rule = '/^[1-2][0-9]{3}-((0([1-9]{1}))|(1[1|2]))-(([0-2]([1-9]{1}))|(3[0|1]))$/';
                break;
        }
        preg_match($rule, $str_preg,$result);
        return $result;
    }
}