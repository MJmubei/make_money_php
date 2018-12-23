<?php
/**
  * Use：微信扫码/JSAPI支付回调
  * Author：kan.yang@starcor.com
  * DateTime：18-12-3 上午11:26
  * Description：标准版微信扫码/JSAPI支付完成后，微信异步回调通知
*/
header("content-type:text/html;charset=utf-8");

//日志路径
include_once dirname(dirname(dirname(__DIR__))) . '/app_model/libraries/em_return.class.php';
$str_olg_file_path = 'api/notify_pay/we_chat/notify_scan';
em_return::set_ci_flow_desc($str_olg_file_path,'微信扫码/JSAPI支付回调:异步通知开始','message','info');

//提取回调数据
$obj_notify_data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');
em_return::set_ci_flow_desc($str_olg_file_path,'微信扫码/JSAPI支付回调:接收微信回调原始数据:' . $obj_notify_data,'message','info');

//解析回调数据
libxml_disable_entity_loader(true);
$arr_notify_data = json_decode(json_encode(simplexml_load_string($obj_notify_data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
if(!isset($arr_notify_data) || empty($arr_notify_data))
{
    em_return::set_ci_flow_desc($str_olg_file_path,'微信扫码/JSAPI支付回调:解析微信回调原始数据失败','message','error');
    return false;
}
unset($obj_notify_data);

//查询订单信息
$str_buy_order = $arr_notify_data['out_trade_no'];






