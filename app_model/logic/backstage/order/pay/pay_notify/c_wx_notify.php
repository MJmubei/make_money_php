<?php
/**
 * Created by PhpStorm.
 * Use : 微信支付回调
 * User: kan.yang@starcor.com
 * Date: 18-12-16
 * Time: 上午11:40
 */

include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Pay/WeChat/WxPay.Api.php';
class logic_wx_notify extends c_nofity_base
{

    /**
     * 回调实现
     */
    public function notify($str_notify_xml)
    {
        em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:开始','message','info');
        em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:微信返回数据。' . var_export($str_notify_xml,true),'message','info');
        //解析回调数据
        $arr_notify_data =  $this->_xml_to_array($str_notify_xml);
        if(!isset($arr_notify_data) || empty($arr_notify_data))
        {
            em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:解析微信回调原始数据失败','message','error');
            return $this->back_msg(1,'失败：解析微信回调原始数据失败');
        }
        //查询订单信息
        $str_order_id   = $arr_notify_data['out_trade_no'];
        $arr_order_info = $this->obj_order_logic->get_one(array('cms_id' => $arr_notify_data['out_trade_no']));
        if($arr_order_info['ret'] != 0 || empty($arr_order_info['data_info']))
        {
            em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:根据【' . $str_order_id . '】查询订单信息失败','message','error');
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
            em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:根据【' . $this->arr_order_info['cms_pay_channel_id'] . '/' . $this->arr_order_info['cms_pay_channel_mode'] . '】查询支付渠道支付方式信息失败','message','error');
            return $this->back_msg(1,'失败：根据【' . $this->arr_order_info['cms_pay_channel_id'] . '/' . $this->arr_order_info['cms_pay_channel_mode'] . '】查询支付渠道支付方式信息失败');
        }
        else
        {
            $arr_pay_config = $arr_pay_config['data_info'];
        }
        //初始化 Pay Config
        WxPayConfig::$APPID = $arr_pay_config['cms_pay_appid'];
        WxPayConfig::$MCHID = $arr_pay_config['cms_pay_partner_id'];
        WxPayConfig::$KEY   = $arr_pay_config['cms_pay_partner_key'];
        //回调处理业务
        $obj_result = WxpayApi::notify(array($this, 'NotifyCallBack'), $str_msg,$str_notify_xml);
        if(is_bool($obj_result) && $obj_result === false)
        {
            em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:' . $str_msg,'message','error');
            return $this->back_msg(1,'FAIL');
        }
        return $this->back_msg(0,'OK');
    }

    /**
     * 支付回调处理业务
     */
    public function notify_call_back($arr_notify_data)
    {
        if(!isset($arr_notify_data['transaction_id']))
        {
            em_return::set_ci_flow_desc($this->str_log_path,'微信扫码/JSAPI支付回调:交易单号不存在,','message','error');
            return false;
        }
        //业务处理
        if(strtoupper($arr_notify_data['result_code']) == 'SUCCESS')
        {//成功

            $bool_logic_ret = $this->logic_init(true,array(
                'cms_buy_order_id' => $this->arr_order_info['cms_id'],
                'cms_pay_order_id' => $arr_notify_data['transaction_id'],
                'cms_reason'       => $arr_notify_data['err_code_des'],
            ));
        }
        else
        {//失败

            $bool_logic_ret = $this->logic_init(false,array(
                'cms_buy_order_id' => $this->arr_order_info['cms_id'],
                'cms_pay_order_id' => $arr_notify_data['transaction_id'],
                'cms_reason'       => $arr_notify_data['err_code_des'],
            ));
        }
        return $bool_logic_ret;
    }

    /**
     * Xml转化为Array
     */
    private function _xml_to_array($str_notify_xml)
    {
        libxml_disable_entity_loader(true);
        $arr_notify_data = json_decode(json_encode(simplexml_load_string($str_notify_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $arr_notify_data;
    }

    /**
     * 组装微信返回信息
     */
    public function back_msg($int_ret,$str_reason)
    {
        $str_result = $int_ret === 0 ? 'SUCCESS' : 'FAIL';
        $str_msg =
        '<xml>' .
            '<return_code><![CDATA['. $str_result . ']]></return_code>' .
            '<return_msg><![CDATA[' . $str_reason . ']]></return_msg>' .
        '</xml>';
        echo $str_msg;
        return $str_result;
    }

}