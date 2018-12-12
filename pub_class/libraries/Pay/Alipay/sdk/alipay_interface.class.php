<?php
/**
 * 支付宝接口封装
 * Author:陈波
 * Date:2015/01/05 18:34:45
 */

require_once("alipay_core.function.php");
require_once("alipay_rsa.function.php");

class nl_alipay_interface
{
	/**
	 * HTTPS形式消息验证地址
	 */
	static $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
	/**
	 * HTTP形式消息验证地址
	 */
	static $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
	/**
	 *支付宝网关地址（新）
	 */
	var $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';
	/**
	 * 默认输入编码
	 */
	static $default__input_charset = 'utf-8';
	/**
	 * 支付宝配置
	 */
	static $alipay_config;

	/**
	 * 财务明细分页查询接口名
	 */
	static $account_query_service_method = 'account.page.query';

	function __construct($alipay_config)
	{
		self::$alipay_config = $alipay_config;
	}

	/**
	 * 针对notify_url验证消息是否是支付宝发出的合法消息
	 * Author:陈波
	 * Date:2015/01/05 18:34:45
	 * @param $param = array(    支付宝异步通知的所有参数,$_POST或者$_GET
	 *               'sign'=>'签名支付串',
	 *               'notify_id'=>'通知ID',
	 *               '...'=>'...',
	 * )
	 * @return string 验证结果
	 */
	public static function verify_notify($param)
	{
		//判断传替来的数组是否为空
		if (empty($param) || empty($param["sign"]) || empty($param["notify_id"]))
		{
			return false;
		}
		//生成签名结果
		$isSign = self::get_sign_veryfy($param, $param["sign"]);
        nl_log_v2_info('k13_a_2', "支付宝APP支付异步通知签名结果:" .$isSign);
		//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
		$responseTxt = 'true';
		if (empty($_POST["notify_id"]))
		{
			return false;
		}
		$responseTxt = self::get_veryfy_response($param["notify_id"]);
        nl_log_v2_info('k13_a_2', "支付宝APP支付异步通知ATN结果:" .$responseTxt);
		//验证
		//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
		//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
        if (preg_match("/true$/i", $responseTxt) && $isSign)
		{
			return true;
		}
		return false;
	}

	/**
	 * 针对return_url验证消息是否是支付宝发出的合法消息
	 * Author:陈波
	 * Date:2015/01/05 18:34:45
	 * @param $param = array(    支付宝同步通知的所有参数,$_POST或者$_GET
	 *               'sign'=>'签名支付串',
	 *               'notify_id'=>'通知ID',
	 *               '...'=>'...',
	 * @return string 验证结果
	 */
	public static function verify_return($param)
	{
		//判断GET来的数组是否为空
		if (empty($param) || empty($param["sign"]) || empty($param["notify_id"]))
		{
			return false;
		}
		//生成签名结果
		$isSign = self::get_sign_veryfy($param, $param["sign"]);
		//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
		$responseTxt = 'true';
		if (!empty($_GET["notify_id"]))
		{
			$responseTxt = self::get_veryfy_response($param["notify_id"]);
		}

		//验证
		//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
		//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
		if (preg_match("/true$/i", $responseTxt) && $isSign)
		{
			return true;
		}
		return false;
	}

	/**
	 * 获取返回时的签名验证结果
	 * Author:陈波
	 * Date:2015/01/05 18:34:45
	 * @param array $param_temp 通知返回来的参数数组
	 * @param string $sign      返回的签名结果
	 * @return 签名验证结果
	 */
	public static function get_sign_veryfy($param_temp, $sign)
	{
		//除去待签名参数数组中的空值和签名参数
		$param_filter = param_filter_empty($param_temp);

		//对待签名参数数组排序
		$param_sort = arg_sort($param_filter);

		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = create_link_string($param_sort);

		$is_sign = false;
		switch (strtoupper(trim(self::$alipay_config['sign_type'])))
		{
			case "MD5" :
				$is_sign = md5_verify($prestr, $sign, self::$alipay_config['key']);
				break;
            case "RSA" :
                // for test
//                echo "\nrsa加密后的sign：\n";
//                echo rsaSign($prestr, self::$alipay_config['private_key_path']);
//                echo "\n传递过来的sign结果\n";
//                echo $sign;
                $is_sign = rsaVerify($prestr, self::$alipay_config['ali_public_key_path'], $sign);
                break;
            case "RSA2" :
                $is_sign = rsaVerify($prestr, self::$alipay_config['ali_public_key_path'], $sign, "RSA2");
                break;
			default :
                $is_sign = false;
		}

		return $is_sign;
	}

	/**
	 * 获取远程服务器ATN结果,验证异步通知的有效性
	 * Author:陈波
	 * Date:2015/01/05 18:34:45
	 * @param $notify_id 通知校验ID
	 * @return 服务器ATN结果
	 *         验证结果集：
	 *         invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
	 *         true 返回正确信息
	 *         false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
	 */
	public static function get_veryfy_response($notify_id)
	{
		$transport = strtolower(trim(self::$alipay_config['transport']));
		$partner = trim(self::$alipay_config['partner']);
		$verify_url = null;
		if ($transport == 'https')
		{
			$verify_url = self::$https_verify_url . "partner=" . $partner . "&notify_id=" . $notify_id;
			nl_log_v2_info('alipay_verify', "支付宝订单查询地址为：" . $verify_url);
			$response_txt = get_http_response_get($verify_url, self::$alipay_config['cacert']);
		}
		else
		{
			$verify_url = self::$http_verify_url . "partner=" . $partner . "&notify_id=" . $notify_id;
			nl_log_v2_info('alipay_verify', "支付宝订单查询地址为：" . $verify_url);
			$response_txt = get_http_response_get($verify_url);
		}
		return $response_txt;
	}

	/**
	 * 生成签名结果
	 * Author:陈波
	 * Date:2015/01/06 14:34:29
	 * @param array $param 要签名的数组
	 * @return atring 签名结果字符串
	 */
	public static function build_request_mysign($param_sort)
	{
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = create_link_string($param_sort);

		$mysign = "";
		switch (strtoupper(trim(self::$alipay_config['sign_type'])))
		{
			case "MD5" :
				$mysign = md5_sign($prestr, self::$alipay_config['key']);
				break;
			default :
				$mysign = "";
		}

		return $mysign;
	}

	/**
	 * 生成要请求给支付宝的参数数组
	 * Author:陈波
	 * Date:2015/01/06 14:34:29
	 * @param array $param_temp 请求前的参数数组
	 * @return array 要请求的参数数组
	 */
	public static function build_request_param($param_temp)
	{
		//除去待签名参数数组中的空值和签名参数
		$param_filter = param_filter_empty($param_temp);

		//对待签名参数数组排序
		$param_sort = arg_sort($param_filter);

		//生成签名结果
		$mysign = self::build_request_mysign($param_sort);

		//签名结果与签名方式加入请求提交参数组中
		$param_sort['sign'] = $mysign;
		$param_sort['sign_type'] = strtoupper(trim(self::$alipay_config['sign_type']));

		return $param_sort;
	}

	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $param_temp 请求前的参数数组
	 * @return 要请求的参数数组字符串
	 */
	function build_request_param_string($param_temp)
	{
		//待请求参数数组
		$param_data = self::build_request_param($param_temp);

		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
		$request_data = create_link_string_urlencode($param_data);

		return $request_data;
	}
	/**
	 * 获取用户账务明细，用于对账
	 * Author:陈波
	 * Date:2015/01/06 14:34:29
	 * @param array $param = array(
	 *                     'page_no'=>'',
	 *                     'page_size'=>'',
	 *                     'gmt_start_time'=>'',
	 *                     'gmt_end_time'=>'',
	 *                     'logon_id'=>'',
	 *                     'iw_account_log_id'=>'',
	 *                     'trade_no'=>'',
	 *                     'merchant_out_order_no'=>'',
	 *                     'deposit_bank_no'=>'',
	 *                     'trans_code'=>'',
	 * )
	 * @return array 返回满足条件的财务明细
	 */
	public static function get_account_bill_query($param)
	{
		$param['service'] = self::$account_query_service_method;
		//如果未指定编码，使用默认
		if(!isset($param['_input_ charset']) || empty($param['_input_ charset']))
		{
			$param['_input_ charset'] = self::$default__input_charset;
		}
		//支付宝商户ID
		if(!isset($param['partner']) || empty($param['partner']))
		{
			$param['partner'] = self::$alipay_config['partner'];
		}
		//当前页码
		if(!isset($param['page_no']) || empty($param['page_no']) || $param['page_no'] < 1)
		{
			$param['page_no'] = 1;
		}
		//每页大小-默认只获取一条数据
		if(!isset($param['page_size']) || empty($param['page_size']) || $param['page_size'] < 1)
		{
			$param['page_size'] = 1;
		}
		//生成请求数据
		$request_data = self::build_request_param_string($param);
		$response_data = get_http_response_post(self::$alipay_gateway_new,self::$alipay_config['cacert'],$request_data,trim(strtolower(self::$alipay_config['input_charset'])));

		return $response_data;
	}
}
