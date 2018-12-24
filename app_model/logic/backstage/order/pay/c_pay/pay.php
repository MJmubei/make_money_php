<?php
/**
 * Created by PhpStorm.
 * Use : 第三方支付平台下单
 * User: kan.yang@starcor.com
 * Date: 18-12-22
 * Time: 下午2:05
 */

//重置时区
ini_set('date.timezone','Asia/Shanghai');
//引入文件
include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Pay/WeChat/WxPay.Api.php';
include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Pay/Alipay/f2fpay/F2fpay.php';
class pay extends em_logic
{

    //订单过期时间
    private $int_expire_time = 7200;

    /**
     * 微信二维码支付
     * @param  array $arr_channel_info array(
            'cms_expire_time'=> '订单过期时间,秒',
            'cms_notify_url' => ''支付回调地址,
     * )
     * @param  array $arr_order_info array(
            'cms_order_id'   => '订单ID',
            'cms_order_name' => '订单名称',
            'cms_order_price'=> '订单金额，元',
            'cms_product_id' => '商品ID',
     * )
     * @return array('ret' => 0/1,'reason' => '描述信息','qr_url' => '支付二维码地址')
     */
    public function wechat_scan($arr_channel_info,$arr_order_info)
    {
        //构造微信接口预支付订单
        $input = new WxPayUnifiedOrder();
        //商品描述信息
        $input->SetBody($arr_order_info['cms_order_name']);
        //附加数据，扩展数据（支付回调时，原数据返回）
        $input->SetAttach('');
        //商家支付订单ID
        $input->SetOut_trade_no($arr_order_info['cms_uuid']);
        //订单金额，分
        $input->SetTotal_fee(1 * 100);
        //订单开始时间
        $input->SetTime_start(date("YmdHis"));
        //订单结束时间
        $int_time_out = !is_numeric($arr_channel_info['cms_expire_time']) || empty($arr_channel_info['cms_expire_time']) ? $this->int_expire_time : $arr_channel_info['cms_expire_time'];
        $input->SetTime_expire(date("YmdHis", time() + $int_time_out));
        //订单优惠标记
        $input->SetGoods_tag('');
        //支付回调地址
        $input->SetNotify_url($arr_channel_info['cms_notify_url']);
        //交易类型
        $input->SetTrade_type("NATIVE");
        //商品ID，必传
        $input->SetProduct_id($arr_order_info['cms_product_id']);

        //下单
        $res = WxPayApi::unifiedOrder($input);

        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),'微信二维码支付预订单：订单【' . $arr_order_info['cms_uuid'] . '】，微信应答信息：' . var_export($res,true));
        //下单失败
        if($res['return_code'] == 'FAIL' || $res['result_code'] == 'FAIL')
        {
            return array('ret' => 1,'reason' => $res['return_msg']);
        }

        //返回二维码地址
        return array('ret' => 0,'reason' => $res['return_msg'],'qr_url' => $res['code_url']);
    }

    /**
     * 支付宝二维码支付
     * @param  array $arr_channel_info array(
            'cms_expire_time'=> '订单过期时间,秒',
            'cms_notify_url' => '支付回调地址',
            'cms_public_key' => '密钥证书路径-公钥',
            'cms_private_key'=> '密钥证书路径-私钥',
     * )
     * @param  array $arr_order_info array(
            'cms_order_id'   => '订单ID',
            'cms_order_name' => '订单名称',
            'cms_order_price'=> '订单金额，元',
            'cms_product_id' => '商品ID',
            'cms_order_num'  => '订单分数，默认1',
     * )
     * @return array('ret' => 0/1,'reason' => '描述信息','qr_url' => '支付二维码地址')
     */
    public function alipay_scan($arr_channel_info,$arr_order_info)
    {
        //组装Config文件
        $arr_config = array (
            'alipay_public_key_file' => '',
            'merchant_private_key_file' => $arr_channel_info['cms_private_key'],
            'merchant_public_key_file' => '',
            'charset'   => "UTF-8",
            'gatewayUrl'=> "https://openapi.alipay.com/gateway.do",
            'app_id'    => $arr_channel_info['cms_pay_appid'],
            'sign_type' => empty($arr_channel_info['cms_sign_type']) ? 'RSA2' : $arr_channel_info['cms_sign_type'],
        );

        //下单
        $obj_f2fpay = new F2fpay($arr_config);
        $int_time_out  = !is_numeric($arr_channel_info['cms_expire_time']) || empty($arr_channel_info['cms_expire_time']) ? $this->int_expire_time : $arr_channel_info['cms_expire_time'];
        $int_order_num = !is_numeric($arr_order_info['cms_order_num']) || empty($arr_order_info['cms_order_num']) ? 1 : $arr_order_info['cms_order_num'];
        $obj_response = $obj_f2fpay->qrpay($int_order_num,$arr_order_info['cms_order_name'],$arr_channel_info['cms_notify_url'],$int_time_out);

        //解析支付宝应答信息
        $obj_response_data = $obj_response->alipay_trade_precreate_response;
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),'支付宝二维码支付预订单：订单【' . $arr_order_info['cms_uuid'] . '】，微信应答信息：' . var_export($obj_response_data,true));
        if ($obj_response_data->code != '10000')
        {
            return array('ret' => 1,'reason' => '失败:支付宝二维码支付处理预订单。错误信息：' . var_export($obj_response ,true));
        }
        $qr_code = $obj_response_data->qr_code;

        return array('ret' => 0,'reason' => '成功','qr_url' => $qr_code);
    }

}