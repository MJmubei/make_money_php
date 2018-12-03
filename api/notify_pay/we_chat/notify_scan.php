<?php
/**
  * Use：微信扫码/JSAPI支付回调
  * Author：kan.yang@starcor.com
  * DateTime：18-12-3 上午11:26
  * Description：标准版微信扫码/JSAPI支付完成后，微信异步回调通知
*/
header("content-type:text/html;charset=utf-8");

//引入文件

include_once dirname(dirname(dirname(__DIR__))) . '/index.php';
include_once dirname(dirname(dirname(__DIR__))) . '/app_model/libraries/em_return.class.php';


//提取回调数据
$obj_notify_data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');

//解析回调数据
libxml_disable_entity_loader(true);
$arr_notify_data = json_decode(json_encode(simplexml_load_string($obj_notify_data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
if(!isset($arr_notify_data) || empty($arr_notify_data))
{
    em_return::set_ci_flow_desc();
}

