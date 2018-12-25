<?php
/**
 * 配置支付宝商户信息
 * Author: 陈波
 * Date: 2015/2/5 18:22
 */

/***************商户基本信息*****************/
//合作身份者ID，以2088开头的16位纯数字
$alipay_config['partner']      = '2088811232586714';

//安全检验码，以数字和字母组成的32位字符
$alipay_config['key']          = '6mexx68vls1tiw31t4fth8n870f3p0wo';
//商户的私钥（后缀是.pen）文件相对路径
$alipay_config['private_key_path']= __DIR__.'/key/rsa_private_key.pem';

//支付宝公钥（后缀是.pen）文件相对路径
$alipay_config['ali_public_key_path']= __DIR__.'/key/alipay_public_key.pem';


//接口签名方式， 支持MD5、DSA、RSA
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//CA证书路径地址，用于CURL中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = __DIR__.'/cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';