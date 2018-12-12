<?php
/**
 * 支付宝统一收单交易退款接口
 *
 * @useage:
 * require_once(path.'alipay_refund.class.php');
 * $refund = new nl_alipay_refund();
 * 设置商户ID
 * $refund->set_app_id($app_id);
 * 设置私钥文件地址
 * $refund->set_rsa_private_key_file_path($path);
 * 设置公钥文件地址
 * $refund->set_rsa_public_key_file_path($path);
 * // 设置签名类型RSA,RSA2
 * // $refund->set_sign_type($val);
 * 设置请求使用的编码格式
 * $refund->set_charset($val);
 * 设置订单支付时传入的商户订单号
 * $refund->set_out_trade_no($val);
 * 设置支付宝交易号，和商户订单号不能同时为空
 * $refund->set_trade_no($val);
 * 设置需要退款的金额，该金额不能大于订单金额,单位为元，支持两位小数
 * $refund->set_refund_amount($val);
 * 设置标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
 * $refund->set_out_request_no($val);
 * 设置标识一次退退款的原因说明
 * $refund->set_refund_reason($val);
 * $response = $refund->refund();
 *
 * 返回格式:
 * array(true/false,
 *     array(
 *          'code'     => 10000,
 *          'msg'      => '',
 *          'data'     => array(
 *              'out_trade_no'         => '',
 *              'fund_channel'         => '',
 *              'refund_pay_timestamp' => '',
 *              'refund_amount'        => 0,
 *              'refund_fee'           => 0,
 *              'refund_real_amount'   => 0,
 *              'trade_no'             => '',
 *          ),
 *      )
 * );
 *
 * @author:  tom.chen <ziwei.chen@starcor.cn>
 * @date:    2017-02-14 17:37:55
 */
defined('__DS__') || define('__DS__', DIRECTORY_SEPARATOR);
defined('SELF_PATH') || define('SELF_PATH', dirname(__FILE__).__DS__);
defined("AOP_SDK_WORK_DIR") || define("AOP_SDK_WORK_DIR", realpath(SELF_PATH.'../../data/log/alipay/'));
defined("AOP_SDK_DEV_MODE") || define("AOP_SDK_DEV_MODE", false);

require_once(SELF_PATH.'aop'.__DS__.'SignData.php');
require_once(SELF_PATH.'lotusphp_runtime'.__DS__.'Logger'.__DS__.'Logger.php');
require_once(SELF_PATH.'aop'.__DS__.'AopClient.php');
require_once(SELF_PATH.'aop'.__DS__.'request'.__DS__.'AlipayTradeRefundRequest.php');
require_once(SELF_PATH.'aop'.__DS__.'request'.__DS__.'AlipayTradeRefundRequest.php');
require_once(SELF_PATH.'alipay_public_code.class.php');
require_once(SELF_PATH.'alipay_response.class.php');

class nl_alipay_refund
{
    // 支付宝退款相关接口数据
    protected $gateway_url               = 'https://openapi.alipay.com/gateway.do';

    protected $app_id                    = '';

    protected $rsa_private_key_file_path = '';

    protected $rsa_public_key_file_path  = '';

    // protected $sign_type                 = 'RSA2';

    protected $timestamp                 = '';

    protected $biz_content               = '';

    protected $version                   = '1.0';

    protected $format                    = 'json';

    protected $charset                   = 'utf-8';

    protected $app_auth_token            = '';

    //以下是退款相关信息

    protected $out_trade_no              = '';

    protected $trade_no                  = '';

    protected $refund_amount             = 0;

    protected $refund_reason             = '';

    protected $out_request_no            = '';

    protected $operator_id               = '';

    protected $store_id                  = '';

    protected $terminal_id               = '';

    private $request;

    private $request_validates           = array(
        'out_trade_no'   => array('noempty' => true, 'regexp'  => '^([\d\w]{1,64})$'),
        'trade_no'       => array('noempty' => true, 'regexp'  => '^([0-9]{1,64})$'),
        'refund_amount'  => array('noempty' => true, 'min' => 0),
        'refund_reason'  => array('noempty' => true, 'min' => 1),
        'out_request_no' => array('noempty' => true, 'regexp'  => '^([\d\w]{1,64})$'),
    );

    private $client_validates = array(
        'app_id'    => array('noempty' => true, 'regexp' => '^([0-9]{1,32})$'),
        // 'sign_type' => array('regexp' => '^(RSA|RSA2)$'),
        'charset'   => array('noempty' => true, 'regexp' => '^(utf-8|gbk|gb2312)$'),
    );

    public function __construct($alipay_config=array(), $refund_config=array())
    {
        (!is_array($alipay_config)) || $alipay_config = array();
        (!is_array($refund_config)) || $refund_config = array();

        $configs = array_merge($alipay_config, $refund_config);

        if (!empty($configs))
        {
            foreach ($configs as $param_name => $param_val) {
                $this->set_params($param_name, $param_val);
            }
        }

        if (!isset($this->timestamp))
        {
            $this->timestamp = date('Y-m-d H:i:s');
        }

        $this->client_validates['rsa_private_key_file_path'] = array('noempty' => true,
            'func' => function($path){
                return is_file($path) && is_readable($path) ?
                                          array(true, null) :
                     array(false, '验证失败，支付宝私钥不存在。');
            }
        );

        $this->client_validates['rsa_public_key_file_path'] = array('noempty' => true,
            'func' => function($path){
                return is_file($path) && is_readable($path) ?
                                          array(true, null) :
                     array(false, '验证失败，支付宝公钥不存在。');
            }
        );
    }

    public function __call($func_name, $args)
    {
        if (preg_match('/^set_([a-z_]+)$/', $func_name, $matches))
        {
            $this->set_params($matches[1], $args[0]);
        }
    }

    protected function set_params($param_name, $vals)
    {
        if (isset($this->$param_name))
        {
            $this->$param_name = $vals;
        }
    }

    public function refund()
    {
        $genrate_res = $this->genrate_request();

        if (!$genrate_res)
        {
            return nl_alipay_response::error(nl_alipay_response::FAILD_GENRATE_BIZ_CONTENT,
                                            $this->error_msg);
        }

        $response = $this->submit_refund_request_to_alipay();

        if (!$response)
        {
            return nl_alipay_response::error(nl_alipay_response::FAILD_VALIDATE_CLIENT_PARAMS,
                                            $this->error_msg);
        }

        return nl_alipay_response::parse($this->request->getApiMethodName(), $response);
    }

    protected function genrate_request()
    {
        $request_datas = array(
            'out_trade_no'   => $this->out_trade_no,
            'trade_no'       => $this->trade_no,
            'refund_amount'  => $this->refund_amount,
            'refund_reason'  => $this->refund_reason,
            'out_request_no' => $this->out_request_no,
        );

        if (!$this->validates($this->requst_validates, $request_datas))
        {
            return false;
        }

        $this->request = new AlipayTradeRefundRequest();
        $this->request->setBizContent(json_encode($request_datas));
        return true;
    }

    protected function submit_refund_request_to_alipay()
    {
        $client_datas = array(
            'app_id'                    => $this->app_id,
            'rsa_private_key_file_path' => $this->rsa_private_key_file_path,
            'rsa_public_key_file_path'  => $this->rsa_public_key_file_path,
            // 'sign_type'                 => $this->sign_type,
            'charset'                   => $this->charset,
        );

        if (!$this->validates($this->client_validates, $client_datas))
        {
            return false;
        }

        $aop = new AopClient();
        $aop->gatewayUrl         = $this->gateway_url;
        $aop->appId              = $this->app_id;
        $aop->rsaPrivateKeyFilePath      = $this->rsa_private_key_file_path;
        $aop->alipayrsaPublicKey = $this->rsa_public_key_file_path;
        $aop->apiVersion         = '1.0';
        // $aop->signType           = $this->sign_type;
        $aop->postCharset        = $this->charset;
        $aop->format             = 'json';

        return $aop->execute($this->request);
    }

    protected function validates($ruler_infos, $datas)
    {
        foreach ($ruler_infos as $test_key => $rulers)
        {
            if (array_key_exists($test_key, $datas))
            {
                list($ok, $msg) = $this->__validate($rulers, $datas[$test_key]);
                if(!$ok)
                {
                    $this->error_msg = sprintf("验证失败,支付宝参数%s%s", $test_key, $msg);
                    return false;
                }
            }
        }

        return true;
    }

    protected function __validate($rulers, $test_data)
    {
        if (empty($rulers))
        {
            return array(true, null);
        }

        foreach ($rulers as $ruler_type => $ruler) {
            switch ($ruler_type)
            {
                case 'noempty':
                    if (empty($test_data))
                    {
                        return array(false, '为空.');
                    }
                    break;
                case 'max':
                    $test_data = is_integer($test_data) ? $test_data : strlen($test_data);

                    if ($test_data > $ruler)
                    {
                        return array(false, sprintf("大于%s.", $ruler));
                    }
                    break;
                case 'min':
                    $test_data = is_integer($test_data) ? $test_data : strlen($test_data);

                    if ($test_data < $ruler)
                    {
                        return array(false, sprintf("小于%s.", $ruler));
                    }
                    break;
                case 'range':
                    $test_data = is_integer($test_data) ? $test_data : strlen($test_data);

                    if (($test_data < $ruler[0]) || $test_data > $ruler[1])
                    {
                        return array(false, sprintf("不在%s-%s范围内.", $ruler[0], $ruler[1]));
                    }
                    break;
                case 'regexp':
                    $ruler = sprintf("/%s/", $ruler);
                    if (false === preg_match($ruler, $test_data))
                    {
                        return array(false, sprintf("不符合规则:%s.", $ruler));
                    }
                    break;
                case 'func':
                    list($ok, $msg) = call_user_func($ruler, $test_data);
                    if (!$ok)
                    {
                        return array(false, $msg);
                    }
                    break;
                default:
                    if ($ruler != $test_data)
                    {
                        return array(false, sprintf("与%s不相等.", $ruler));
                    }
            }
        }

        return array(true, null);
    }
}
