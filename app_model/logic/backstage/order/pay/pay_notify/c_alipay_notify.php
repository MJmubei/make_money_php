<?php
/**
 * Created by PhpStorm.
 * Use : 支付回调
 * User: kan.yang@starcor.com
 * Date: 18-12-16
 * Time: 上午11:29
 */

include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Pay/WeChat/WxPay.Api.php';
class logic_alipay_notify extends c_nofity_base
{

    public function notify($arr_notify_data)
    {
        em_return::set_ci_flow_desc($this->str_log_path,'支付宝当面付-支付回调:开始','message','info');
        em_return::set_ci_flow_desc($this->str_log_path,'支付宝当面付-支付回调:支付宝返回数据。' . var_export($arr_notify_data,true),'message','info');
        //查询订单信息
        $str_order_id   = $arr_notify_data['out_trade_no'];
        $arr_order_info = $this->obj_order_logic->get_one(array('cms_id' => $arr_notify_data['out_trade_no']));
        if($arr_order_info['ret'] != 0 || empty($arr_order_info['data_info']))
        {
            em_return::set_ci_flow_desc($this->str_log_path,'支付宝当面付-支付回调:根据【' . $str_order_id . '】查询订单信息失败','message','error');
            return $this->back_msg(1,'失败：根据【' . $str_order_id . '】查询订单信息失败');
        }
        else
        {
            $this->arr_order_info = $arr_order_info['data_info'];
            unset($arr_order_info);
        }



    }


    /**
     * @反馈信息
     */
    public function back_msg($int_ret,$str_reason)
    {
        $str_result = $int_ret === 0 ? 'TRADE_SUCCESS' : 'TRADE_ERROR';
        echo json_encode(array('trade_status' => $str_result,'trade_msg' => $str_reason));
        return $str_result;
    }

} 