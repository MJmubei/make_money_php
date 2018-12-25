<?php
/**
 * Created by PhpStorm.
 * User: kan.yang@starcor.com
 * Date: 18-12-4
 * Time: 下午1:41
 */
ini_set('date.timezone','Asia/Shanghai');

include_once dirname(__FILE__) . '/f2fpay/F2fpay.php';
class alipay_test
{

    public function scan()
    {
        $config = array (
            'alipay_public_key_file' => '',
            'merchant_private_key_file' => dirname(__FILE__) . '/f2fpaykey/rsa_private_key.pem"',
            'merchant_public_key_file' => '',
            'charset'   => "UTF-8",
            'gatewayUrl'=> "https://openapi.alipay.com/gateway.do",
            'app_id'    => '2018102661891020',
            'sign_type' => 'RSA2'
        );

        $f2fpay = new F2fpay($config);

        $response = $f2fpay->qrpay(
            '45802641847665915820351516681065',
            1,
            '支付宝统一下单：二维码支付Demo',
            'http://172.31.14.136:808/self/ClothingOrderingSystem/api/notify_pay/we_chat/notify_scan.php',
            7200
        );

        $alipay_trade_precreate_response_obj = $response->alipay_trade_precreate_response;
        if ($alipay_trade_precreate_response_obj->code != '10000')
        {
            return array('ret' => 1,'reason' => '支付宝二维码支付处理预订单失败，返回信息为：' . var_export($response ,true));
        }

        $qr_code = $alipay_trade_precreate_response_obj->qr_code;

        return array('ret' => 0,'reason' => '成功','qr_url' => $qr_code);
    }

} 