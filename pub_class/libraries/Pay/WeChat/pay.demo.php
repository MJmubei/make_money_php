<?php
/**
 * Created by PhpStorm.
 * User: kan.yang@starcor.com
 * Date: 18-12-4
 * Time: 下午1:41
 */
ini_set('date.timezone','Asia/Shanghai');

include_once dirname(__FILE__) . '/WxPay.Api.php';
class test
{

    /**
     * 二维码支付
     */
    public function scan()
    {
        //构造微信接口预支付订单
        $input = new WxPayUnifiedOrder();
        //商品描述信息
        $input->SetBody('微信统一下单：二维码支付Demo');
        //附加数据，扩展数据（支付回调时，原数据返回）
        $input->SetAttach('');
        //商家支付订单ID
        $input->SetOut_trade_no('45802641847665915820351516681065');
        //订单金额，分
        $input->SetTotal_fee(1 * 100);
        //订单开始时间
        $input->SetTime_start(date("YmdHis"));
        //订单结束时间。TODO 这个需要加到配置文件里面去
        $input->SetTime_expire(date("YmdHis", time() + 7200));
        //订单优惠标记
        $input->SetGoods_tag('');
        //支付回调地址
        $input->SetNotify_url('http://172.31.14.136:808/self/ClothingOrderingSystem/api/notify_pay/we_chat/notify_scan.php');
        //交易类型
        $input->SetTrade_type("NATIVE");
        //商品ID，必传
        $input->SetProduct_id('45802641847665915820351516681065');

        //下单
        $res = WxPayApi::unifiedOrder($input);

        //下单失败
        if($res['return_code'] == 'FAIL' || $res['result_code'] == 'FAIL')
        {
            return array('ret' => 1,'reason' => $res['return_msg']);
        }

        //返回二维码地址
        return array('ret' => 0,'reason' => $res['return_msg'],'qr_url' => $res['code_url']);
    }

    /**
     * 网页支付
     */
    public function web($str_open_id)
    {
        //构造微信接口预支付订单
        $input = new WxPayUnifiedOrder();
        //商品描述信息
        $input->SetBody('微信统一下单：网页支付Demo');
        //附加数据，扩展数据（支付回调时，原数据返回）
        $input->SetAttach('');
        //商家支付订单ID
        $input->SetOut_trade_no('45802641847665915820351516681065');
        //订单金额，分
        $input->SetTotal_fee(1 * 100);
        //订单开始时间
        $input->SetTime_start(date("YmdHis"));
        //订单结束时间 TODO 这个需要加到配置文件里面去
        $input->SetTime_expire(date("YmdHis", time() + 7200));
        //订单优惠标记
        $input->SetGoods_tag('');
        //支付回调地址
        $input->SetNotify_url('http://172.31.14.136:808/self/ClothingOrderingSystem/api/notify_pay/we_chat/notify_scan.php');
        //交易类型
        $input->SetTrade_type("JSAPI");
        //商品ID
        $input->SetProduct_id('');
        //用户标识，必填
        $input->SetOpenid($str_open_id);

        //统一下单
        $res = WxPayApi::unifiedOrder($input);

        //下单失败
        if($res['return_code'] == 'FAIL' || $res['result_code'] == 'FAIL')
        {
            return false;
        }

        //构造返回数据
        $data = array();
        $data['appId'] = WxPayConfig::$APPID;
        $now_time = time();
        $data['timeStamp'] = $now_time;
        $data['nonceStr'] = '45802641847665915820351516681065';
        $package = 'prepay_id=' . $res['prepay_id'];
        $data['package'] = $package;
        $data['signType'] = 'MD5';
        $data['sign'] = $this->make_sign($data, WxPayConfig::$KEY);
        $data['timeStamp'] = (string)$now_time;

        return $data;
    }

    private function make_sign($params, $key)
    {
        //签名步骤一：按字典序排序参数
        ksort($params);
        $string = $this->to_url_params($params);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    private function to_url_params($params)
    {
        $buff = "";
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

} 