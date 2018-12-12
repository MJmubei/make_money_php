<?php
/*
 *支付宝对象工厂，使用抽象工厂模式，获得一些列的产品，AOPClient，业务请求对象，响应处理对象
 */

include_once dirname(__FILE__).DIRECTORY_SEPARATOR."aop".DIRECTORY_SEPARATOR."AopClient.php";
include_once dirname(__FILE__).DIRECTORY_SEPARATOR."aop".DIRECTORY_SEPARATOR."SignData.php";

interface nl_alipay_factory
{
    //初始化，包括支付宝配置，业务配置
    public function __construct($alipay_config, $business_config);

    //创建aopClient
    public function create_aop_client();

    //创建业务请求对象
    public function create_business_request();

    //创建响应处理对象
    public function create_business_response();

}