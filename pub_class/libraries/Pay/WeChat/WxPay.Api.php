<?php

/**
 * Created by PhpStorm.
 * Use : 微信支付API列表的封装
 * User: kan.yang@starcor.com
 * Date: 18-12-03
 * Desc: 下午20:10
 */

include_once dirname(__FILE__) . "/WxPay.Exception.php";
include_once dirname(__FILE__) . "/WxPay.Config.php";
include_once dirname(__FILE__) . "/WxPay.Data.php";
class WxPayApi
{
	/**
	 * 
	 * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayUnifiedOrder $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function unifiedOrder($inputObj, $timeOut = 10)
	{
        //下单基地址
		$url = self::getWeixinServerUrl() . '/pay/unifiedorder';
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数out_trade_no！");
		}
        else if(!$inputObj->IsBodySet())
		{
			throw new WxPayException("缺少统一支付接口必填参数body！");
		}
        else if(!$inputObj->IsTotal_feeSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数total_fee！");
		}
        else if(!$inputObj->IsTrade_typeSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数trade_type！");
		}
		//关联参数
		if($inputObj->GetTrade_type() == "JSAPI" && !$inputObj->IsOpenidSet())
		{
			throw new WxPayException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
		}
		if($inputObj->GetTrade_type() == "NATIVE" && !$inputObj->IsProduct_idSet())
		{
			throw new WxPayException("统一支付接口中，缺少必填参数product_id！trade_type为NATIVE时，product_id为必填参数！");
		}
		//异步通知url未设置，则使用配置文件中的url
		if(!$inputObj->IsNotify_urlSet())
		{
			$inputObj->SetNotify_url(WxPayConfig::$NOTIFY_URL);//异步通知url
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
        //微信统一下单接口只能使用ipv4地址，对ipv6地址做兼容
        $ipv4 = self::getIP();
        $ip_arr = explode(':', $ipv4);
        if(count($ip_arr) > 1)
        {
            $ipv4 = $ip_arr[count($ip_arr)-1];
        }
		$inputObj->SetSpbill_create_ip($ipv4);//终端ip
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		//签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 
	 * 查询订单，WxPayOrderQuery中out_trade_no、transaction_id至少填一个
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayOrderQuery $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function orderQuery($inputObj, $timeOut = 6)
	{
		$url = self::getWeixinServerUrl() . '/pay/orderquery';

		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet())
        {
			throw new WxPayException("订单查询接口中，out_trade_no、transaction_id至少填一个！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 
	 * 关闭订单，WxPayCloseOrder中out_trade_no必填
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayCloseOrder $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function closeOrder($inputObj, $timeOut = 6)
	{
        //下单基地址
		$url = self::getWeixinServerUrl() . '/pay/closeorder';
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet())
        {
			throw new WxPayException("订单查询接口中，out_trade_no必填！");
		}
        //公众账号ID
		$inputObj->SetAppid(WxPayConfig::$APPID);
        //商户号
		$inputObj->SetMch_id(WxPayConfig::$MCHID);
        //随机字符串
		$inputObj->SetNonce_str(self::getNonceStr());
        //签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();
        //请求开始时间
		$startTimeStamp = self::getMillisecond();
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
        //上报请求花费时间
		self::reportCostTime($url, $startTimeStamp, $result);
		
		return $result;
	}

	/**
	 * 
	 * 申请退款，WxPayRefund中out_trade_no、transaction_id至少填一个且
	 * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayRefund $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function refund($inputObj, $timeOut = 6)
	{
		$url = self::getWeixinServerUrl() . '/secapi/pay/refund';

		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet())
        {
			throw new WxPayException("退款申请接口中，out_trade_no、transaction_id至少填一个！");
		}
        else if(!$inputObj->IsOut_refund_noSet())
        {
			throw new WxPayException("退款申请接口中，缺少必填参数out_refund_no！");
		}
        else if(!$inputObj->IsTotal_feeSet())
        {
			throw new WxPayException("退款申请接口中，缺少必填参数total_fee！");
		}
        else if(!$inputObj->IsRefund_feeSet())
        {
			throw new WxPayException("退款申请接口中，缺少必填参数refund_fee！");
		}
        else if(!$inputObj->IsOp_user_idSet())
        {
			throw new WxPayException("退款申请接口中，缺少必填参数op_user_id！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, true, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 
	 * 查询退款
	 * 提交退款申请后，通过调用该接口查询退款状态。退款有一定延时，
	 * 用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
	 * WxPayRefundQuery中out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayRefundQuery $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function refundQuery($inputObj, $timeOut = 6)
	{
		$url = self::getWeixinServerUrl()  . '/pay/refundquery';

		//检测必填参数
		if(!$inputObj->IsOut_refund_noSet() &&
			!$inputObj->IsOut_trade_noSet() &&
			!$inputObj->IsTransaction_idSet() &&
			!$inputObj->IsRefund_idSet())
        {
			throw new WxPayException("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 下载对账单，WxPayDownloadBill中bill_date为必填参数
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayDownloadBill $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function downloadBill($inputObj, $timeOut = 6)
	{
		$url = self::getWeixinServerUrl() . '/pay/downloadbill';

		//检测必填参数
		if(!$inputObj->IsBill_dateSet())
        {
			throw new WxPayException("对账单接口中，缺少必填参数bill_date！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		if(substr($response, 0 , 5) == "<xml>"){
			return "";
		}
		return $response;
	}
	
	/**
	 * 提交被扫支付API
	 * 收银员使用扫码设备读取微信用户刷卡授权码以后，二维码或条码信息传送至商户收银台，
	 * 由商户收银台或者商户后台调用该接口发起支付。
	 * WxPayWxPayMicroPay中body、out_trade_no、total_fee、auth_code参数必填
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param object $inputObj
	 * @param int $timeOut
	 */
	public static function micropay($inputObj, $timeOut = 10)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/pay/micropay';

		//检测必填参数
		if(!$inputObj->IsBodySet()) {
			throw new WxPayException("提交被扫支付API接口中，缺少必填参数body！");
		} else if(!$inputObj->IsOut_trade_noSet()) {
			throw new WxPayException("提交被扫支付API接口中，缺少必填参数out_trade_no！");
		} else if(!$inputObj->IsTotal_feeSet()) {
			throw new WxPayException("提交被扫支付API接口中，缺少必填参数total_fee！");
		} else if(!$inputObj->IsAuth_codeSet()) {
			throw new WxPayException("提交被扫支付API接口中，缺少必填参数auth_code！");
		}
		
		$inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 
	 * 撤销订单API接口，WxPayReverse中参数out_trade_no和transaction_id必须填写一个
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayReverse $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 */
	public static function reverse($inputObj, $timeOut = 6)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/secapi/pay/reverse';

		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {
			throw new WxPayException("撤销订单API接口中，参数out_trade_no和transaction_id必须填写一个！");
		}
		
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, true, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
	/**
	 * 
	 * 测速上报，该方法内部封装在report中，使用时请注意异常流程
	 * WxPayReport中interface_url、return_code、result_code、user_ip、execute_time_必填
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayReport $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function report($inputObj, $timeOut = 1)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/payitil/report';

		//检测必填参数
		if(!$inputObj->IsInterface_urlSet()) {
			throw new WxPayException("接口URL，缺少必填参数interface_url！");
		} if(!$inputObj->IsReturn_codeSet()) {
			throw new WxPayException("返回状态码，缺少必填参数return_code！");
		} if(!$inputObj->IsResult_codeSet()) {
			throw new WxPayException("业务结果，缺少必填参数result_code！");
		} if(!$inputObj->IsUser_ipSet()) {
			throw new WxPayException("访问接口IP，缺少必填参数user_ip！");
		} if(!$inputObj->IsExecute_time_Set()) {
			throw new WxPayException("接口耗时，缺少必填参数execute_time_！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetUser_ip($_SERVER['REMOTE_ADDR']);//终端ip
		$inputObj->SetTime(date("YmdHis"));//商户上报时间	 
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		return $response;
	}
	
	/**
	 * 
	 * 生成二维码规则,模式一生成支付二维码
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayBizPayUrl $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function bizpayurl($inputObj, $timeOut = 6)
	{
		if(!$inputObj->IsProduct_idSet()){
			throw new WxPayException("生成二维码，缺少必填参数product_id！");
		}
		
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetTime_stamp(time());//时间戳	 
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		
		return $inputObj->GetValues();
	}
	
	/**
	 * 
	 * 转换短链接
	 * 该接口主要用于扫码原生支付模式一中的二维码链接转成短链接(weixin://wxpay/s/XXXXXX)，
	 * 减小二维码数据量，提升扫描速度和精确度。
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayShortUrl $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function shorturl($inputObj, $timeOut = 6)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/tools/shorturl';

		//检测必填参数
		if(!$inputObj->IsLong_urlSet()) {
			throw new WxPayException("需要转换的URL，签名用原串，传输需URL encode！");
		}
		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		
		return $result;
	}
	
 	/**
 	 * 
 	 * 支付结果通用通知
 	 * @param string $callback
 	 * 直接回调函数使用方法: notify(you_function);
 	 * 回调类成员函数方法:notify(array($this, you_function));
 	 * $callback  原型为：function function_name($data){}
 	 */
	public static function notify($callback, &$msg)
	{
		//获取通知的数据
		$xml = isset($GLOBALS['HTTP_RAW_POST_DATA'])?$GLOBALS['HTTP_RAW_POST_DATA']:file_get_contents('php://input');
		//如果返回成功则验证签名
		try {
			$result = WxPayResults::Init($xml);
		} catch (WxPayException $e){
			$msg = $e->errorMessage();
			return false;
		}
		return call_user_func($callback, $result);
	}
	
	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return string 产生的随机字符串
	 */
	public static function getNonceStr($length = 32) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}
	
	/**
	 * 直接输出xml
	 * @param string $xml
	 */
	public static function replyNotify($xml)
	{
		echo $xml;
	}
	
	/**
	 * 
	 * 上报数据， 上报的时候将屏蔽所有异常流程
	 * @param string $usrl
	 * @param int $startTimeStamp
	 * @param array $data
	 */
	private static function reportCostTime($url, $startTimeStamp, $data)
	{
		//如果不需要上报数据
		if(WxPayConfig::REPORT_LEVENL == 0){
			return;
		} 
		//如果仅失败上报
		if(WxPayConfig::REPORT_LEVENL == 1 &&
			 array_key_exists("return_code", $data) &&
			 $data["return_code"] == "SUCCESS" &&
			 array_key_exists("result_code", $data) &&
			 $data["result_code"] == "SUCCESS")
		 {
		 	return;
		 }
		 
		//上报逻辑
		$endTimeStamp = self::getMillisecond();
		$objInput = new WxPayReport();
		$objInput->SetInterface_url($url);
		$objInput->SetExecute_time_($endTimeStamp - $startTimeStamp);
		//返回状态码
		if(array_key_exists("return_code", $data)){
			$objInput->SetReturn_code($data["return_code"]);
		}
		//返回信息
		if(array_key_exists("return_msg", $data)){
			$objInput->SetReturn_msg($data["return_msg"]);
		}
		//业务结果
		if(array_key_exists("result_code", $data)){
			$objInput->SetResult_code($data["result_code"]);
		}
		//错误代码
		if(array_key_exists("err_code", $data)){
			$objInput->SetErr_code($data["err_code"]);
		}
		//错误代码描述
		if(array_key_exists("err_code_des", $data)){
			$objInput->SetErr_code_des($data["err_code_des"]);
		}
		//商户订单号
		if(array_key_exists("out_trade_no", $data)){
			$objInput->SetOut_trade_no($data["out_trade_no"]);
		}
		//设备号
		if(array_key_exists("device_info", $data)){
			$objInput->SetDevice_info($data["device_info"]);
		}
		
		try{
			self::report($objInput);
		} catch (WxPayException $e){
			//不做任何处理
		}
	}

	/**
	 * 以post方式提交xml到对应的接口url
	 * 
	 * @param string $xml  需要post的xml数据
	 * @param string $url  url
	 * @param bool $useCert 是否需要证书，默认不需要
	 * @param int $second   url执行超时时间，默认30s
	 * @throws WxPayException
	 */
	private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
	{		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		//如果有配置代理这里就设置代理
		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
			&& WxPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}
		curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上，
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //存在请求微信域名解析慢的问题，设置允许程序选择想要解析的 IP 地址类别，指定为IPV4
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	
		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::$SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::$SSLKEY_PATH);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			if (function_exists('curl_error')){
                $error_msg = curl_error($ch);
            }else{
			    $error_msg = "";
            }

			curl_close($ch);
			throw new WxPayException("curl出错，错误码:$error" . " 错误信息:" . $error_msg);
		}
	}
	
	/**
	 * 获取毫秒级别的时间戳
	 */
	private static function getMillisecond()
	{
		//获取毫秒的时间戳
		$time = explode ( " ", microtime () );
		$time = $time[1] . ($time[0] * 1000);
		$time2 = explode( ".", $time );
		$time = $time2[0];
		return $time;
	}

	private static function getWeixinServerUrl()
	{
        //TODO 这个需要加到配置文件里面去
		return 'https://api.mch.weixin.qq.com';
	}

    /**
     * 获取IP地址
     */
    private static function getIP()
    {
        if (isset($_SERVER))
        {
            if (isset($_SERVER['HTTP_CDN_SRC_IP']) && !empty($_SERVER['HTTP_CDN_SRC_IP'])){
                $ip=$_SERVER['HTTP_CDN_SRC_IP'];
                $ip = trim($ip);
                if (self::checkIpValid($ip)) return $ip;
            }

            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ips = $_SERVER['HTTP_X_FORWARDED_FOR'];
                $ips = urldecode($ips);
                $arr = explode(',', $ips);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr as $ip)
                {
                    $ip = trim($ip);

                    if ($ip != 'unknown' && !empty($ip))
                    {
                        if (self::checkIpValid($ip)) return $ip;
                    }
                }
            }

            if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            {
                $ip=$_SERVER['HTTP_CLIENT_IP'];
                $ip = trim($ip);
                if (self::checkIpValid($ip)) return $ip;
            }

            if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            {
                $ip=$_SERVER['REMOTE_ADDR'];
                $ip = trim($ip);
                if (self::checkIpValid($ip)) return $ip;
            }
        }
        else
        {
            if (getenv('HTTP_X_FORWARDED_FOR'))
            {
                $ips = getenv('HTTP_X_FORWARDED_FOR');
                $ips = urldecode($ips);
                $arr = explode(',', $ips);

                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr as $ip)
                {
                    $ip = trim($ip);

                    if ($ip != 'unknown' && !empty($ip))
                    {
                        if (self::checkIpValid($ip)) return $ip;
                    }
                }
            }
            if (getenv('HTTP_CLIENT_IP'))
            {
                $ip = getenv('HTTP_CLIENT_IP');
                $ip = trim($ip);
                if (self::checkIpValid($ip)) return $ip;
            }
            if (getenv('REMOTE_ADDR'))
            {
                $ip = getenv('REMOTE_ADDR');
                $ip = trim($ip);
                if (self::checkIpValid($ip)) return $ip;
            }
        }

        return '0.0.0.0';
    }

    /**
     * IP类型
     */
    private static function checkIpValid($ip)
    {
        $bool = filter_var($ip,FILTER_VALIDATE_IP, FILTER_FLAG_IPV4|FILTER_FLAG_IPV6);
        //ipv4 和ipv6都不是返回false
        if(!$bool)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


	/**
	 *
	 * 支付的同时完成代扣协议的签约，
	 * WxPayContractOrder中appid,mch_id,contract_mchid,,contract_appid,out_trade_no,
	 * nonce_str,body,notify_url,total_fee,spbill_create_ip,trade_type,
	 * plan_id,contract_code,request_serial,contract_display_account,contract_notify_url
	 * 必填
	 * @param WxPayContractOrder $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return object 成功时返回，其他抛异常
	 */
	public static function contractOrder($inputObj, $timeOut = 10)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/pay/contractorder';

		// 检测必填参数
		if(!$inputObj->IsOut_trade_noSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数out_trade_no！");
		}
		else if(!$inputObj->IsBodySet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数body！");
		}
		else if(!$inputObj->IsNotify_urlSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数notify_url！");
		}
		else if(!$inputObj->IsTotal_feeSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数total_fee！");
		}
//		else if(!$inputObj->IsSpbill_create_ipSet())
//		{
//			throw new WxPayException("缺少支付中签约接口必填参数spbill_create_ip！");
//		}
		else if(!$inputObj->IsTrade_typeSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数trade_type！");
		}
		else if(!$inputObj->IsPlan_idSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数plan_id！");
		}
		else if(!$inputObj->IsContract_codeSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数contract_code！");
		}
		else if(!$inputObj->IsRequest_serialSet())
		{
			throw new WxPayException("缺少支付中签约接口必填参数request_serial！");
		}
		else if(!$inputObj->IsContract_display_account())
		{
			throw new WxPayException("缺少支付中签约接口必填参数contract_display_account！");
		}
		else if(!$inputObj->IsContract_notify_url())
		{
			throw new WxPayException("缺少支付中签约接口必填参数contract_notify_url！");
		}

		// 关联参数
		if($inputObj->GetTrade_type() == "JSAPI" && !$inputObj->IsOpenidSet())
		{
			throw new WxPayException("支付中签约接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
		}
		if($inputObj->GetTrade_type() == "NATIVE" && !$inputObj->IsProduct_idSet())
		{
			throw new WxPayException("支付中签约接口中，缺少必填参数product_id！trade_type为JSAPI时，product_id为必填参数！");
		}

		//公众账号ID
		$inputObj->SetAppid(WxPayConfig::$APPID);
		//商户号
		$inputObj->SetMch_id(WxPayConfig::$MCHID);

		// APP和网页支付提交用户端ip,Native支付填调用微信支付API的机器IP.
		if ($inputObj->GetTrade_type() == 'NATIVE')
		{
			// Native支付填调用微信支付API的机器IP
			$ipv4 = $_SERVER['SERVER_ADDR'];
		}
		else
		{
			//微信统一下单接口只能使用ipv4地址，对ipv6地址做兼容
			$ipv4 = self::getIP();
			$ip_arr = explode(':', $ipv4);
			if(count($ip_arr) > 1)
			{
				$ipv4 = $ip_arr[count($ip_arr)-1];
			}
		}

		if (empty($ipv4))
		{
			$ipv4 = '127.0.0.1';
		}
		$inputObj->SetSpbill_create_ip($ipv4);//终端ip
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串

		//签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();

		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		return $result;
	}

	/**
	 *
	 * 申请解约
	 * WxPayDeleteContract中appid,mch_id,contract_termination_remark,version
	 * 必填
	 *
	 * 其中 plan_id+contract_code   contract_id  两者必须填一个
	 * @param WxPayDeleteContract $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return object 成功时返回，其他抛异常
	 */
	public static function deleteContract($inputObj, $timeOut = 10)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/papay/deletecontract';

		// 检测必填参数
		if(!$inputObj->IsContract_termination_remarkSet())
		{
			throw new WxPayException("缺少解约接口必填参数解约备注contract_termination_remark！");
		}

		if (!$inputObj->IsPlan_idSet() && !$inputObj->IsContract_codeSet()
			&& !$inputObj->IsContract_idSet())
		{
			throw new WxPayException("缺少解约接口必填Plan_id,Contract_code,Contract_id！");
		}

		// 设置参数
		//公众账号ID
		$inputObj->SetAppid(WxPayConfig::$APPID);
		//商户号
		$inputObj->SetMch_id(WxPayConfig::$MCHID);
		$inputObj->SetVersion('1.0');

		//签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();

		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
		return $result;
	}


	/**
	 *
	 * 申请扣款，WxPayPapPayApply中body,out_trade_no,total_fee
	 * 回调通知url notify_url,contract_id必填
	 * @param WxPayPapPayApply $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return string 成功时返回，其他抛异常
	 */
	public static function papPayApply($inputObj, $timeOut = 10)
	{
		$pay_url = self::getWeixinServerUrl();
		$url = $pay_url . '/pay/pappayapply';
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数out_trade_no！");
		}
		else if(!$inputObj->IsBodySet())
		{
			throw new WxPayException("缺少统一支付接口必填参数body！");
		}
		else if(!$inputObj->IsTotal_feeSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数total_fee！");
		}
		else if(!$inputObj->IsNotify_urlSet())
		{
			throw new WxPayException("缺少统一支付接口必填参数回调通知url！");
		}
		else if(!$inputObj->IsContract_idSet()) {
			throw new WxPayException("缺少统一支付接口必填参数委托代扣协议id！");
		}

		$inputObj->SetAppid(WxPayConfig::$APPID);//公众账号ID
		$inputObj->SetMch_id(WxPayConfig::$MCHID);//商户号

		//微信统一下单接口只能使用ipv4地址，对ipv6地址做兼容
		$ipv4 = self::getIP();
		$ip_arr = explode(':', $ipv4);
		if(count($ip_arr) > 1)
		{
			$ipv4 = $ip_arr[count($ip_arr)-1];
		}

		$inputObj->SetClientip($ipv4);//点分IP格式(客户端IP)
		if (empty($_SERVER['SERVER_ADDR']))
		{
			$_SERVER['SERVER_ADDR'] = '127.0.0.1';
		}
		$inputObj->SetSpbill_create_ip($_SERVER['SERVER_ADDR']);//调用微信支付API的机器IP
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		$inputObj->SetTrade_type('PAP');// 交易类型PAP-微信委托代扣支付

		//签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();

		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut);
		$result = WxPayResults::Init($response);
		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间

		return $result;
	}
}

