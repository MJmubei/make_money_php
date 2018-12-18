<?php
/**
 * Created by PhpStorm.
 * Use : 支付回调
 * User: kan.yang@starcor.com
 * Date: 18-12-16
 * Time: 上午11:29
 */
header("content-type:text/html;charset=utf-8");

defined('BASEPATH') or exit('No direct script access allowed');
class c_notify extends CI_Controller
{

    /**
     * 微信支付回调
     */
    public function wx_notify()
    {
        //提取回调数据
        $obj_notify_data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');
        //引入文件
        include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/order/pay/pay_notify/c_wx_notify.php';
        $obj_logic_wx_notify = new logic_wx_notify($this);

        return $obj_logic_wx_notify->notify($obj_notify_data);
    }

    /**
     * 支付宝支付回调
     */
    public function alipay_notify()
    {
        //引入文件
        include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/order/pay/pay_notify/c_alipay_notify.php';
        $obj_logic_alipay_notify = new logic_alipay_notify($this);

        return $obj_logic_alipay_notify->notify($_POST);
    }


} 