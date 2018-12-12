<?php
/**
 * K13_A_9支付宝账务分页明细
 * @FileName : order_check_app.php
 * @Author : LiuXiao <xiao.liu@starcor.cn>
 * @DateTime : 2015-03-06 16:29
 */

ini_set("max_execution_time","120");
header("content-type:text/html;charset=utf-8");
require_once('../k13_common.php');
require_once('alipay_config.php');
include_logic('alipay/alipay_interface');

// 文本日志初始化
$log_module = 'k13_a_９';
nl_log_v2_init_manager($log_module);
nl_log_v2_info($log_module, "支付宝账务分页明细:" . var_export($_GET, true));

if(!isset($_GET))
{
	echo "fail";
    exit();
}

// 获取参数或验证参数
$data = $_GET;
$data['service'] = 'account.page.query';
$data['partner'] = '2088811232586714';
$data['_input_charset'] = 'utf-8';
$data['sign_type'] = 'MD5';

$sign_type = $data['sign_type'];
$data = get_signd_params($data, $alipay_config, $sign_type);

$sendUrl = 'https://mapi.alipay.com/gateway.do?';
$cookie = '';
$back = send_post($sendUrl, $data, $cookie);

header("Content-type: text/xml");
echo $back;

//验证失败