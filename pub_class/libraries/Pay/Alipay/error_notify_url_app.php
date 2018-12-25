<?php
/**
 * 支付宝APP支付异步错误通知地址
 * @author 陈波
 * Date: 2015/2/ 16:59
 */
ini_set("max_execution_time","120");
header("content-type:text/html;charset=utf-8");
require_once('../k13_common.php');
require_once('alipay_config.php');
include_logic('alipay/alipay_interface');
include_logic('pay/pay_order');
include_logic('pay/partner_booked');


// 文本日志初始化
$log_module = 'k13_a_3';
nl_log_v2_init_manager($log_module);
nl_log_v2_info($log_module, "支付宝APP支付业务异常:" . var_export($_POST, true));

// db日志初始化
$log_dc = k13_common::get_log_dc();
$log_arr = k13_common::$log_arr;
$log_arr['interface_name'] = 'k13_a_3';
$log_arr['request_data'] = !empty($_POST) ? var_export($_POST, true) : '无';

//计算得出通知验证结果
$alipay_notify = new nl_alipay_interface($alipay_config);
$verify_result = $alipay_notify->verify_notify($_POST);
//验证失败
if($verify_result !== true)
{
    //添加DB日志
    $log_arr['status'] = '20012';
    $log_arr['desc'] = '失败';
    k13_common::add_pay_log($log_dc, $log_arr);
    echo "fail";
    exit();
}
//验证成功

//商户订单号
$out_trade_no = $_POST['out_trade_no'];
//支付宝交易号
$trade_no = $_POST['trade_no'];
//交易状态
$trade_status = $_POST['trade_status'];
if($_POST['trade_status'] == 'TRADE_FINISHED')
{
    echo "SUCCESS";
    exit();
}
else if ($_POST['trade_status'] == 'TRADE_SUCCESS')
{
    echo "SUCCESS";
    exit();
}
//输出成功信息给支付宝，否则支付宝会重复发送通知
echo "SUCCESS";