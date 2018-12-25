<?php
/**
 *
 * 支付宝wap支付回调
 * @author kang.lu
 * Date: 2016/08/25
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

// 获取配置
$alipay_config = k13_get_pay_config_by_order_id($_POST['out_trade_no']);
// 数据库返回key与配置key不一致
if (empty($alipay_config['key']))
{
    $alipay_config['key'] = $alipay_config['pay_partner_key'];
}
if (empty($alipay_config['partner']))
{
    $alipay_config['partner'] = $alipay_config['pay_partner_id'];
}

$alipay_pay_notify_obj = new alipay_pay_notify_callback($alipay_config);
// 处理支付回调
$alipay_pay_notify_obj->NotifyProcess();