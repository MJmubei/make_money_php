<?php
/**
 *
 * 支付宝二维码支付回调
 * @author jun.he@starcor.cn
 * Date: 2016/08/19
 *
 */
ini_set("max_execution_time","120");
header("content-type:text/html;charset=utf-8");
include_once dirname(__FILE__).'/alipay_pay_notify.php';
include_once '../k13_common.php';
include_logic('manager/alipay/alipay_interface');
include_logic('manager/pay/partner_booked');
include_logic('manager/pay/pay_order_v2');
include_logic('manager/pay/pay_order_controller');
include_logic('manager/pay/pay_order');
include_logic('manager/pay/pay_callback.class.php');
include_logic('manager/pay/pay_order_log');

include_logic('manager/vboss/buy_order');
include_logic('manager/vboss/deal_buy_order');
include_logic('manager/vboss/deal_auth');
include_logic('manager/vboss/deal_boss_money');
include_logic('manager/vboss/upgrade_product');

include_logic('manager/scaaa/core/c_user_product_v2');
include_logic('manager/scaaa/core/c_user_product_video_v2');
include_logic('manager/scaaa/core/c_device_product_v2');
include_logic('manager/scaaa/core/c_device_product_video_v2');
include_logic('manager/scaaa/core/c_product_auth_change_record');
include_logic('manager/scaaa/product_fee');
include_logic('manager/scaaa/core/c_product_v2');
include_logic('manager/scaaa/core/c_upgrade_product_v2');
include_logic('manager/scaaa/core/c_product_video_v2');
include_logic('manager/scaaa/user_v2');
include_logic('manager/scaaa/core/c_user_v2');
include_logic('manager/scaaa/core/c_video_v2');
include_logic('manager/scaaa/core/c_vod_media_v2');
include_logic('manager/pay/pay_notify');
include_logic('manager/pay/pay_callback');

nl_log_v2_init_manager("alipay");
nl_log_v2_info("alipay", "支付宝异步通知开始，请求数据为：" . var_export($_POST, true));

//提取订单ID
$pay_order_id = isset($_POST['out_trade_no'])?$_POST['out_trade_no']:'';
//查找渠道配置信息
$pay_config = k13_common::get_pay_config($pay_order_id);
nl_log_v2_info("alipay", "当前支付宝配置为：" . var_export($pay_config, true));

if($pay_config === false)
{
    return false;
}
else if($pay_config['type'] === 1)
{
    //生成公钥，私钥文件
    $pay_dc = k13_common::get_pay_dc();
    $project_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
    $mode_id = $pay_config['payment_info']['pay_mode_id'];
    $private_key_content = hex2bin($pay_config['data']['nns_private_key']);
    $private_key_path = k13_common::get_cacert_file($project_dir, $pay_dc, $pay_config['data'], $mode_id, 'nns_private_key', $private_key_content);
    $public_key_content = hex2bin($pay_config['data']['nns_public_key']);
    $public_key_path = k13_common::get_cacert_file($project_dir, $pay_dc, $pay_config['data'], $mode_id, 'nns_public_key', $public_key_content);

    //构造配置参数
    $alipay_config = array(
        'partner' => $pay_config['data']['nns_pay_partner_id'],
        'key' => $pay_config['data']['nns_pay_partner_key'],
        'private_key_path' => $private_key_path['data'],
        'ali_public_key_path' => $public_key_path['data'],
        'sign_type' => empty($pay_config['data']['nns_sign_type'])?'RSA':$pay_config['data']['nns_sign_type'],
        'input_charset' => $pay_config['data']['nns_input_charset'],
        'cacert' => $pay_config['data']['nns_cacert'],
        'transport' => $pay_config['data']['nns_transport'],
        'seller_email' => '',
    );
}
else
{
    // 引入配置文件
    $alipay_config = include 'alipay_config_qr.php';
}
$alipay_pay_notify_obj = new alipay_pay_notify_callback($alipay_config);
// 处理支付回调
$alipay_pay_notify_obj->NotifyProcess();