<?php
/*
 * 支付宝请求封装基础类，使用时初始化一个alipay_factory类对象，传入该类，即可实现该支付宝相关接口
 */
include_once "alipay_factory.interface.php";

class nl_alipay_request_base
{
    protected $alipay_factory = null;

    protected $aop_client = null;

    protected $request_obj = null;

    protected $response_obj = null;

    public function __construct($alipay_factory)
    {
        if(empty($alipay_factory))
        {
            return false;
        }

        $this->alipay_factory = $alipay_factory;
    }

    //支付宝请求标准逻辑
    final public function alipay_request()
    {
        //获取所需的三种对象
        $this->prepare();

        //aop执行对账请求
        $result = $this->aop_client->execute($this->request_obj);

        //设置reponse的api_name
        $this->response_obj->set_api_name($this->request_obj->getApiMethodName());

        return $this->response_obj->parse($result);
    }

    protected function prepare()
    {
        //创建aop_client
        $this->aop_client = $this->alipay_factory->create_aop_client();

        //创建业务请求对象
        $this->request_obj = $this->alipay_factory->create_business_request();

        //创建业务处理对象
        $this->response_obj = $this->alipay_factory->create_business_response();

        return;
    }
}