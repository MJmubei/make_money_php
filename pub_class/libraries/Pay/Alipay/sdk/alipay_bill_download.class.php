<?php
/**
 * 支付宝对账，封装请求参数，发起支付宝对账
 * @author:  kang.lu
 * @date:    2017-03-10
 */
//define('__DS__', DIRECTORY_SEPARATOR);
defined('__DS__') or define('__DS__', DIRECTORY_SEPARATOR);
include_once dirname(__FILE__).__DS__."aop".__DS__."request".__DS__."AlipayDataDataserviceBillDownloadurlQueryRequest.php";
include_once "alipay_bill_download_response.class.php";
include_once "alipay_core.function.php";

class nl_alipay_bill_download implements nl_alipay_factory
{
    //支付宝配置，用于初始化aopClient
    protected $app_id = '';

    protected $rsa_private_key_file_path = '';//支付宝私钥文件路径

    protected $alipay_rsa_public_key = '';//支付宝公钥

    protected $gateway_url = 'https://openapi.alipay.com/gateway.do';

    protected $version = '1.0';

    protected $sign_type = 'RSA';//RSA,RSA2

    protected $charset = 'utf-8';//utf-8,gbk,gb2312等

    protected $format = 'json'; //支付宝目前仅支持json

    //对账参数配置，用于初始化AlipayDataDataserviceBillDownloadurlQueryRequest对象
    //订单类型；trade指商户基于支付宝交易收单的业务账单；signcustomer是指基于商户支付宝余额收入及支出等资金变动的帐务账单；
    protected $bill_type = '';

    //账单时间：日账单格式为yyyy-MM-dd，月账单格式为yyyy-MM。
    protected $bill_date = '';

    //参数检查规则
    protected $alipay_rules = array(
        'app_id' => array('not null', 'reg_rule'=>'/^([0-9]{1,32})$/'),
        // 'alipay_rsa_public_key' => array('not null', 'reg_rule'=>'/^([0-9]|[A-Z]|[a-z]){1,32}$/'),
        'rsa_private_key_file_path' => array(),
    );

    //业务规则
    protected $business_rules = array(
        'bill_type' => array('not null', 'reg_rule'=>'/^(trade|signcustomer){1}$/'),//trade,signcustomer
        'bill_date' => array('not null', 'reg_rule'=>'/^\d{4}(\-)\d{1,2}\1\d{1,2}$/'),//账单时间：日账单格式为yyyy-MM-dd，月账单格式为yyyy-MM。
    );

    //初始化，进行入参检查并赋值
    //alipay_config 包括app_id,alipay_rsa_public_key，rsa_private_key_file_path
    //bill_download_config包括bill_type,bill_date
    public function __construct($alipay_config, $bill_download_config)
    {
        //获取必填数组
        $alipay_not_null_rules = get_arr_by_key_val($this->alipay_rules, 0, 'not null');
        $business_not_null_rules = get_arr_by_key_val($this->business_rules, 0, 'not null');
        //检查支付宝参数、赋值
        foreach($this->alipay_rules as $field_name=>$rule)
        {
            list($code, $msg) = $this->check_param_and_init($field_name, $rule['reg_rule'], $alipay_not_null_rules, $alipay_config);
            if(!$code)
            {
                return false;
            }
        }

        //检查对账请求参数、赋值
        foreach($this->business_rules as $field_name=>$rule)
        {
            list($code, $msg) = $this->check_param_and_init($field_name, $rule['reg_rule'], $business_not_null_rules, $bill_download_config);
            if(!$code)
            {
                return false;
            }
        }
        $this->set_param('sign_type',$alipay_config['new_sign_type']);
    }

    private function check_param_and_init($field_name, $rule, $not_null_rules, $input_arr)
    {
        if($field_name == 'rsa_private_key_file_path')
        {
            $this->rsa_private_key_file_path = $input_arr['rsa_private_key_file_path'];
            return check_file_path($input_arr['rsa_private_key_file_path']);
        }

        //检查必填字段是否正确
        if(!array_key_exists($field_name, $not_null_rules))
        {
            return array(false, $field_name.'变量值必填，请检查');
        }

        //正则检查参数值
        if(!preg_match($rule, $input_arr[$field_name]))
        {
            return array(false, $field_name."参数值非法，请确认");
        }

        //赋值
        $this->set_param($field_name, $input_arr[$field_name]);

        return array(true, 'ok');
    }

    //设置参数
    public function set_param($param_name, $val)
    {
        if (isset($this->$param_name))
        {
            $this->$param_name = $val;
        }
    }

    public function create_aop_client()
    {
        $aop = new AopClient();
        $aop->gatewayUrl               = $this->gateway_url;
        $aop->appId                     = $this->app_id;
        $aop->rsaPrivateKeyFilePath  = $this->rsa_private_key_file_path;
        $aop->alipayPublicKey         = $this->alipay_rsa_public_key;
        $aop->apiVersion               = $this->version;
        $aop->postCharset              = $this->charset;
        $aop->format                    = $this->format;
        $aop->setSignType($this->sign_type);
        return $aop;
    }

    public function create_business_request()
    {
        //获取请求对象数据
        $request_data = array(
            'bill_type' => $this->bill_type,
            'bill_date' => $this->bill_date,
        );

        $request = new AlipayDataDataserviceBillDownloadurlQueryRequest();
        $request->setBizContent(json_encode($request_data));

        return $request;
    }

    public function create_business_response()
    {
        //获取请求对象数据
        return new nl_alipay_bill_download_response();
    }
}