<?php
/**
  * Use：自定义项目配置 + 全局配置
  * Author：kan.yang@starcor.cn
  * DateTime：18-12-16 下午2:32
  * Description：
  * ========================================================================================
*/

/*========================================== 全局变量 开始 ===================================*/

//交易成功
define('TRADE_SUCCESS', 310001);
//交易失败
define('TRADE_FAIL', 310002);
//处理中
define('TRADE_PROCESS', 310003);
//退款中
define('TRADE_REFUND', 310004);
//订单状态缓存时间
define('ORDER_STATUS_BUFF_TIME',1800);
//成功状态码
define('NF_RETURN_SUCCESS_CODE',0);
//失败状态码
define('NF_RETURN_ERROR_CODE',1);



/*========================================== 全局变量 结束 ===================================*/

//253短信配置项
$arr_config_app['short_message_config'] = array(
    'api_send_url' => 'dysmsapi.aliyuncs.com',                 //请求地址
    'api_account'  => 'LTAIzDNqjq2w6NdI',                      //Access Id
    'api_password' => 'ZqFBhPCfFcHU7pRqB1bpSMSZ5p5w95',        //Access Secret
    'api_sign_name'=> '云裳供应链',                             //短信签名
    'api_template_code' => 'SMS_152853072',                    //短信模板ID
);


/*========================================== 系统配置 开始 ===================================*/

//添加实例：$arr_config_app[''] = '';

/*========================================== 系统配置 结束 ===================================*/

