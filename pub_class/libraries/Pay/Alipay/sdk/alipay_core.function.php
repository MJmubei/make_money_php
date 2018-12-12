<?php
/**
 * 支付宝的核心公用函数封装
 * Author:陈波
 * Date:2015/01/05 18:34:45
 */

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param array $param 需要拼接的数组
 * return string 拼接完成以后的字符串
 */
function create_link_string($param)
{
	$arg = '';
	while (list ($key, $val) = each($param))
	{
		$arg .= $key . '=' . $val . '&';
	}
	//去掉最后一个&字符
	$arg = substr($arg, 0, count($arg) - 2);

	//如果存在转义字符，那么去掉转义
	if (get_magic_quotes_gpc())
	{
		$arg = stripslashes($arg);
	}

	return $arg;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param array $param 需要拼接的数组
 * return string 拼接完成以后的字符串
 */
function create_link_string_urlencode($param)
{
	$arg = "";
	while (list ($key, $val) = each($param))
	{
		$arg .= $key . "=" . urlencode($val) . "&";
	}
	//去掉最后一个&字符
	$arg = substr($arg, 0, count($arg) - 2);

	//如果存在转义字符，那么去掉转义
	if (get_magic_quotes_gpc())
	{
		$arg = stripslashes($arg);
	}

	return $arg;
}

/**
 * 除去数组中的空值和签名参数
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param array $param 签名参数组
 * return string 去掉空值与签名参数后的新签名参数组
 */
function param_filter_empty($param)
{
	$param_filter = array ();
	while (list ($key, $val) = each($param))
	{
		if ($key == "sign" || $key == "sign_type" || $val == "")
		{
			continue;
		}
		else
		{
			$param_filter[$key] = $param[$key];
		}
	}

	return $param_filter;
}

/**
 * 对数组排序
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param array $param 排序前的数组
 * return string 排序后的数组
 */
function arg_sort($param)
{
	ksort($param);
	reset($param);

	return $param;
}

/**
 * 远程获取数据，POST模式
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $url           指定URL完整路径地址
 * @param $cacert_url    指定当前工作目录绝对路径
 * @param $param          请求的数据
 * @param $input_charset 编码格式。默认值：空值
 * return 远程输出的数据
 */
function get_http_response_post($url, $cacert_url, $param, $input_charset = '')
{

	if (trim($input_charset) != '')
	{
		$url = $url . "_input_charset=" . $input_charset;
	}
	$curl = curl_init($url);
	//SSL证书认证
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	//严格认证
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	//证书地址
	curl_setopt($curl, CURLOPT_CAINFO, $cacert_url);
	//过滤HTTP头
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//显示输出结果
	curl_setopt($curl, CURLOPT_POST, true);
	//post传输数据
	curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
	//post传输数据
	$responseText = curl_exec($curl);
	//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
	//var_dump( curl_error($curl) );
	curl_close($curl);

	return $responseText;
}

/**
 * 远程获取数据，GET模式
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $url        指定URL完整路径地址
 * @param $cacert_url 指定当前工作目录绝对路径
 * return 远程输出的数据
 */
function get_http_response_get($url, $cacert_url)
{
	$curl = curl_init($url);
	//过滤HTTP头
	curl_setopt($curl, CURLOPT_HEADER, 0);
	//显示输出结果
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	// 如果传入证书地址则认为是https请求
	if (!empty($cacert_url))
	{
		// SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		// 严格认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		// 证书地址
		curl_setopt($curl, CURLOPT_CAINFO, $cacert_url);
	}
	$responseText = curl_exec($curl);
	curl_close($curl);

	return $responseText;
}

/**
 * 实现多种字符编码方式
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $input           需要编码的字符串
 * @param $_output_charset 输出的编码格式
 * @param $_input_charset  输入的编码格式
 * return 编码后的字符串
 */
function charset_encode($input, $_output_charset, $_input_charset)
{
	$output = '';
	if (empty($_output_charset))
	{
		$_output_charset = $_input_charset;
	}
	if ($_input_charset == $_output_charset || $input == null)
	{
		$output = $input;
	}
	elseif (function_exists("mb_convert_encoding"))
	{
		$output = mb_convert_encoding($input, $_output_charset, $_input_charset);
	}
	elseif (function_exists("iconv"))
	{
		$output = iconv($_input_charset, $_output_charset, $input);
	}
	else
	{
		return false;
	}

	return $output;
}

/**
 * 实现多种字符解码方式
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $input           需要解码的字符串
 * @param $_output_charset 输出的解码格式
 * @param $_input_charset  输入的解码格式
 * return 解码后的字符串
 */
function charset_decode($input, $_input_charset, $_output_charset)
{
	$output = "";
	if (empty($_input_charset))
	{
		$_input_charset = $_output_charset;
	}
	if ($_input_charset == $_output_charset || $input == null)
	{
		$output = $input;
	}
	elseif (function_exists("mb_convert_encoding"))
	{
		$output = mb_convert_encoding($input, $_output_charset, $_input_charset);
	}
	elseif (function_exists("iconv"))
	{
		$output = iconv($_input_charset, $_output_charset, $input);
	}
	else
	{
		return false;
	}

	return $output;
}

/**
 * 签名字符串
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $prestr 需要签名的字符串
 * @param $key    私钥
 * return 签名结果
 */
function md5_Sign($prestr, $key)
{
	$prestr = $prestr . $key;

	return md5($prestr);
}

/**
 * 验证签名
 * Author:陈波
 * Date:2015/01/05 18:34:45
 * @param $prestr 需要签名的字符串
 * @param $sign   签名结果
 * @param $key    私钥
 * return 签名结果
 */
function md5_verify($prestr, $sign, $key)
{
	$prestr = $prestr . $key;
	$mysgin = md5($prestr);
	nl_log_v2_info($this->log_module, "支付MD5签名串为:" . var_export($mysgin, true));

	if ($mysgin == $sign)
	{
		return true;
	}
	return false;
}

/**
 * 检查传入数据是否为空
 * Author:陈波
 * Date: 2014/06/25 10:27
 * @param type $data 数据
 * @param type $filed 需要检查的字段
 */
function check_params($data, $filed)
{
	foreach ($filed as $key)
	{
		if (!isset($data[$key]) || (empty($data[$key]) && $data[$key] === ''))
		{
			return $key;
		}
	}

	return false;
}

/**
 * 处理待签名参数，构造sign值。
 *
 * @param array $params_to_be_sign 待签名参数
 * @param array $alipay_config 支付宝配置
 * @param string $sign_type 签名类型
 *
 * return array
 */
function get_signd_params($params_to_be_sign, $alipay_config, $sign_type)
{
    $sign = '';
    //除去待签名参数数组中的空值和签名参数
    $param_filter = param_filter_empty($params_to_be_sign);
    //对待签名参数数组排序
    $param_sort = arg_sort($param_filter);
    //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
    $prestr = create_link_string($param_sort);

    if ($sign_type == 'RSA') {
        $priKey = file_get_contents($alipay_config['private_key_path']);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($prestr, $sign, $res);
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
    } elseif ($sign_type == 'MD5') {
        $key = $alipay_config['key'];
        $sign = md5_Sign($prestr, $key);
    }

    // 构造sign
    $params_to_be_sign['sign'] = $sign;
    $params_to_be_sign['sign_type'] = $sign_type;

    return $params_to_be_sign;
}

/**
 * 发送get数据.
 *
 * @param string $sendUrl 地址url.
 * @param string $cookie  需要传递的cookie.
 *
 * @return mixed
 */
function send_get($sendUrl, $cookie)
{
    $ch = curl_init($sendUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * 发送post数据.
 *
 * @param string $sendUrl  地址url.
 * @param string $curlPost 传递的数据.
 * @param string $cookie  需要传递的cookie.
 *
 * @return mixed
 */
function send_post($sendUrl, $curlPost, $cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sendUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function check_file_path($file_path)
{
    if(is_file($file_path) && is_readable($file_path))
    {
        return array(true, 'OK');
    }

    //文件不存在或不可读
    return array(false, '验证失败，支付宝私钥文件不存在或不可读。');
}

function format_return($ret_code, $alipay_code, $reason, $data)
{
    //默认返回格式
    $ret = array(
        'code'     => $ret_code,
        'alipay_code' => $alipay_code,
        'msg'      => $reason,
        'data'     => $data,
    );

    return $ret;
}

function get_arr_by_key_val($arr, $where_key, $where_val)
{
    if(!is_array($arr) || !is_array(reset($arr)) || !isset(reset($arr)[$where_key]))
    {
        return false;
    }

    $ret_arr = array();
    foreach($arr as $key=>$item)
    {
        if($item[$where_key] == $where_val)
        {
            $ret_arr[$key] = $item;
        }
    }

    return $ret_arr;
}