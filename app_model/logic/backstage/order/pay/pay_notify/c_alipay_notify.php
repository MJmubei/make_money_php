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

    //交易状态说明
    private $arr_error_code = array(
        'WAIT_BUYER_PAY' => '交易创建，等待买家付款',
        'TRADE_CLOSED'   => '未付款交易超时关闭，或支付完成后全额退款',
        'TRADE_SUCCESS'  => '交易支付成功',
        'TRADE_FINISHED' => '交易结束，不可退款',
    );

    /**
     * 回调实现
     */
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
        //查询支付方式内容
        $arr_pay_config = $this->obj_channel_mode_logic->get_one(array('cms_id' => $this->arr_order_info['cms_pay_channel_id'],'cms_channel_id' => $this->arr_order_info['cms_pay_channel_mode']));
        if($arr_pay_config['ret'] != 0 || empty($arr_pay_config['data_info']))
        {
            em_return::set_ci_flow_desc($this->str_log_path,'支付宝当面付-支付回调:根据【' . $this->arr_order_info['cms_pay_channel_id'] . '/' . $this->arr_order_info['cms_pay_channel_mode'] . '】查询支付渠道支付方式信息失败','message','error');
            return $this->back_msg(1,'失败：根据【' . $this->arr_order_info['cms_pay_channel_id'] . '/' . $this->arr_order_info['cms_pay_channel_mode'] . '】查询支付渠道支付方式信息失败');
        }
        else
        {
            $arr_pay_config = $arr_pay_config['data_info'];
        }
        //构造配置参数
        $arr_alipay_config  = array(
            'partner'       => $arr_pay_config['nns_pay_partner_id'],
            'key'           => $arr_pay_config['nns_pay_partner_key'],
            'sign_type'     => empty($arr_pay_config['cms_sign_type']) ? 'RSA2' : $arr_pay_config['cms_sign_type'],
            'input_charset' => $arr_pay_config['cms_input_charset'],
            'cacert'        => $arr_pay_config['cms_apiclient_cert'],
            'transport'     => $arr_pay_config['nns_transport'],
            'seller_email'  => '',
            'private_key_path'    => $arr_pay_config['cms_private_key'],
            'ali_public_key_path' => $arr_pay_config['cms_public_key'],
        );
        //验签
        include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Pay/Alipay/sdk/alipay_interface.class.php';
        $obj_alipay_interface = new nl_alipay_interface($arr_alipay_config);
        $bool_verify_ret = $obj_alipay_interface->verify_notify($arr_notify_data);
        if (!$bool_verify_ret)
        {
            return $this->back_msg(1,'失败：支付宝回调数据非法');
        }
        //业务处理
        if(strtoupper($arr_notify_data['trade_status']) == 'TRADE_SUCCESS')
        {//支付成功

            $bool_logic_ret = $this->logic_init(0,array(
                'cms_buy_order_id' => $this->arr_order_info['cms_id'],
                'cms_pay_order_id' => $arr_notify_data['trade_no'],
                'cms_reason'       => $this->arr_error_code[$arr_notify_data['trade_status']],
            ));
        }
        elseif(strtoupper($arr_notify_data['trade_status']) == 'WAIT_BUYER_PAY')
        {//等待交易

            $bool_logic_ret = $this->logic_init(2,array(
                'cms_buy_order_id' => $this->arr_order_info['cms_id'],
                'cms_pay_order_id' => $arr_notify_data['trade_no'],
                'cms_reason'       => $this->arr_error_code[$arr_notify_data['trade_status']],
            ));
        }
        else
        {//交易失败

            $bool_logic_ret = $this->logic_init(1,array(
                'cms_buy_order_id' => $this->arr_order_info['cms_id'],
                'cms_pay_order_id' => $arr_notify_data['trade_no'],
                'cms_reason'       => $this->arr_error_code[$arr_notify_data['trade_status']],
            ));
        }
        return $this->back_msg($bool_logic_ret ? 0 : 1,$this->arr_error_code[$arr_notify_data['trade_status']]);
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