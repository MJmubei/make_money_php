<?php
/**
 * 调用微信订单查询接口
 * @author:  song.xiang
 * @date:    2018-06-13 09:41
 */

defined('__DS__') || define('__DS__', DIRECTORY_SEPARATOR);
defined('SELF_PATH') || define('SELF_PATH', dirname(__FILE__).__DS__);
require_once(SELF_PATH.'aop'.__DS__.'SignData.php');
//require_once(SELF_PATH.'lotusphp_runtime'.__DS__.'Logger'.__DS__.'Logger.php');
require_once(SELF_PATH.'aop'.__DS__.'AopClient.php');
require_once(SELF_PATH.'aop'.__DS__.'request'.__DS__.'AlipayTradeQueryRequest.php');
require_once(SELF_PATH.'alipay_public_code.class.php');

class nl_alipay_order_query {
/**
 * 文档：
 * https://docs.open.alipay.com/api_1/alipay.trade.query
 * 请求：
 * $aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = 'your app_id';
$aop->rsaPrivateKey = '请填写开发者私钥去头去尾去回车，一行字符串';
$aop->alipayrsaPublicKey='请填写支付宝公钥，一行字符串';
$aop->apiVersion = '1.0';
$aop->signType = 'RSA2';
$aop->postCharset='GBK';
$aop->format='json';
$request = new AlipayTradeQueryRequest ();
$request->setBizContent("{" .
"\"out_trade_no\":\"20150320010101001\"," .
"\"trade_no\":\"2014112611001004680 073956707\"" .
"  }");
$result = $aop->execute ( $request);

$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
$resultCode = $result->$responseNode->code;
if(!empty($resultCode)&&$resultCode == 10000){

} else {

}
 * 响应：
 * {
    "alipay_trade_query_response": {
        "code": "10000",
        "msg": "Success",
        "trade_no": "2013112011001004330000121536",
        "out_trade_no": "6823789339978248",
        "buyer_logon_id": "159****5620",
        "trade_status": "TRADE_CLOSED",
        "total_amount": 88.88,
        "trans_currency": "TWD",
        "settle_currency": "USD",
        "settle_amount": 2.96,
        "pay_currency": 1,
        "pay_amount": "8.88",
        "settle_trans_rate": "30.025",
        "trans_pay_rate": "0.264",
        "buyer_pay_amount": 8.88,
        "point_amount": 10,
        "invoice_amount": 12.11,
        "send_pay_date": "2014-11-27 15:45:57",
        "receipt_amount": "15.25",
        "store_id": "NJ_S_001",
        "terminal_id": "NJ_T_001",
        "fund_bill_list": [
            {
                "fund_channel": "ALIPAYACCOUNT",
                "bank_code": "CEB",
                "amount": 10,
                "real_amount": 11.21
            }
        ],
        "store_name": "证大五道口店",
        "buyer_user_id": "2088101117955611",
        "auth_trade_pay_mode": "CREDIT_PREAUTH_PAY",
        "buyer_user_type": "PRIVATE",
        "mdiscount_amount": "88.88",
        "discount_amount": "88.88"
    },
    "sign": "ERITJKEIJKJHKKKKKKKHJEREEEEEEEEEEE"
}
 */
    public static function order_query($app_id,$rsaPrivateKey, $alipayrsaPublicKey, $out_trade_no ,$trade_no) {
		$aop = new AopClient ();
		$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
		$aop->appId = $app_id;
		$aop->rsaPrivateKeyFilePath = $rsaPrivateKey;
		$aop->alipayrsaPublicKey= $alipayrsaPublicKey;
		$aop->apiVersion = '1.0';
		//$aop->signType = 'RSA';
		$aop->postCharset='UTF-8';
		$aop->format='json';
		$request = new AlipayTradeQueryRequest ();
		/*$request->setBizContent("{" .
		"\"out_trade_no\":\"20150320010101001\"," .
		"\"trade_no\":\"2014112611001004680 073956707\"" .
		"  }");*/
		$bizContent =  array(
            'out_trade_no'   => $out_trade_no,
            'trade_no'       => $trade_no,
        );
		$request->setBizContent(json_encode($bizContent));
		$result = $aop->execute ( $request);

		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		//$resultCode = $result->$responseNode->code;
        return  (json_decode(json_encode($result->$responseNode),true));
/*		return array(
		   'code' =>$result->$responseNode->code,
		   'msg' => $result->$responseNode->msg . $result->$responseNode->sub_msg,
		   'trade_no'=> $result->$responseNode->trade_no,
		   'out_trade_no' => $result->$responseNode->out_trade_no,
		   //交易状态：WAIT_BUYER_PAY（交易创建，等待买家付款）、TRADE_CLOSED（未付款交易超时关闭，或支付完成后全额退款）、
		   //TRADE_SUCCESS（交易支付成功）、TRADE_FINISHED（交易结束，不可退款）
		   'trade_status' => $result->$responseNode->trade_status,
		   //交易的订单金额，单位为元，两位小数。该参数的值为支付时传入的total_amount
		   'total_amount' => $result->$responseNode->total_amount,
		   //'trade_status' => $result->$responseNode->trade_status,
		   //'trade_status' => $result->$responseNode->trade_status,
		);*/
    }
}
