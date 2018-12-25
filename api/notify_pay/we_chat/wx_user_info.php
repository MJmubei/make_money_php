<?php
/**
 * Created by PhpStorm.
 * Use : 网页获取微信用户信息接口
 * User: kan.yang@starcor.com
 * Date: 18-12-4
 * Time: 下午8:40
 */

//初始化全局变量
defined('NF_RETURN_SUCCESS_CODE') || define('NF_RETURN_SUCCESS_CODE', 0);
defined('NF_RETURN_ERROR_CODE') || define('NF_RETURN_ERROR_CODE', 1);
defined('WEB_OAUTH_LOG_MODEL') || define('WEB_OAUTH_LOG_MODEL', 'wx_web_oauth');

//引入文件
$str_base_path = dirname(dirname(dirname(__DIR__)));
include_once $str_base_path . '/app_model/libraries/em_return.class.php';
$str_olg_file_path = 'api/notify_pay/we_chat/wx_user_info';
em_return::set_ci_flow_desc($str_olg_file_path,'网页获取微信用户信息:开始','message','info');

//微信公共号配置 TODO 需要后台配置
$arr_account_info = array(
    'nns_pub_account_id'=> 'gh_03d722e910b6',                    //公众号
    'nns_app_id'        => 'wx468207fac44fb47d',                 //APPID
    'nns_app_secret'    => '832edef00923dfd731a8c02816bd39a2',   //AppSecret
    'nns_access_token'  => 'starcor',                            //公众号token
);

//重定向逻辑
if (isset($_GET['code']))
{//如果是从微信跳转回来的,则根据code获取到openid，再根据openid获取用户信息

    include_once $str_base_path . '/pub_class/libraries/Curl.class.php';
    $obj_curl = new np_http_curl_class();
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:微信回调回来的请求参数：" . var_export($_REQUEST, true),'message','info');

    $str_code = $_REQUEST['code'];
    //拼接获取OpenId的请求串儿
    $str_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$arr_account_info['nns_app_id']}&secret".
    "={$arr_account_info['nns_app_secret']}&code={$str_code}&grant_type=authorization_code";
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:获取OpenId的请求地址：" . $str_url,'message','info');
    //获取openid
    $str_content = $obj_curl->get($str_url);
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:获取OpenId信息后，微信应答原始数据：" . $str_content,'message','info');
    $arr_re = json_decode($str_content, true);
    //解析请求结果内容
    if(empty($arr_re['openid']))
    {
        $str_content = $obj_curl->file_contents_http_request($str_url);
        $arr_re = json_decode($str_content, true);
    }
    //不包含openid
    if (!isset($arr_re['openid']))
    {
        em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:根据code，获取tokan失败。Curl错误信息：" . $obj_curl->curl_error(),'message','error');
    }

    //根据openid获取用户信息 TODO 需要加入配置文件
    $arr_weixin_api_url = array(
        'get_user_info_api' => 'https://api.weixin.qq.com/cgi-bin/user/info?lang=zh_CN',     //获取关注用户信息接口
        'get_qr_ticket' => 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=',  //获取二维码ticket接口
        'get_qr_code' => 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=',              //获取二维码接口
        'web_code' => 'https://open.weixin.qq.com/connect/oauth2/authorize',                 //网页获取code的接口
        'web_access_token' => 'https://api.weixin.qq.com/sns/oauth2/access_token',           //网页获取access_token的接口地址
    );
    //获取用户信息
    $str_get_user_info_url = $arr_weixin_api_url['get_user_info_api'] . '&access_token=' . $arr_account_info['nns_access_token'] . '&openid=' . $arr_re['openid'];
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:获取用户信息的请求地址：" . $str_get_user_info_url,'message','info');
    //发送HTTP请求
    $str_user_info = $obj_curl->file_contents_http_request($str_get_user_info_url);
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:获取用户信息时，微信应答原始数据：" . $str_user_info,'message','info');
    $arr_user_info = json_decode($str_user_info, true);
    if (isset($arr_user_info['errcode']))
    {
        em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:获取用户信息为空或者解析数据失败",'message','error');
    }
    //跳转回来源地址
    $str_url = urldecode($_REQUEST['web_replace_state_url']);
    $str_hash = urldecode($_REQUEST['web_header_hash']);
    if (strpos($str_url, '?') === false)
    {
        $str_url .= "?account_id={$arr_account_info['nns_pub_account_id']}&wx_user_info=" . $str_user_info;
    }
    else
    {
        $str_url .= "&account_id={$arr_account_info['nns_pub_account_id']}&wx_user_info=" . $str_user_info;
    }
    $str_url .= $str_hash;

    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信用户信息:重定向地址：" . $str_url,'message','info');
    header("Location:{$str_url}");
}
else
{//如果是从其他要获取微信用户信息的页面跳转过来的，则记录地址，跳转到微信去获取code

    $str_header_url = $_SERVER['HTTP_REFERER'];
    $str_haeder_hash = $_GET['hash'];
    //重定向地址：本机地址 TODO 后台配置
    $g_wx_epg_domain = 'http://172.31.14.136:808/self/ClothingOrderingSystem';
    $g_wx_epg_domain = rtrim($g_wx_epg_domain, '/');
    $str_script_name = ltrim($_SERVER['SCRIPT_NAME'], '/');
    //处理LUA增加phpexecute
    if(strstr($str_script_name,'phpexecute'))
    {
        $str_script_name = str_replace('phpexecute//','',$str_script_name);
    }
    //瓶装微信回调地址
    if (empty($_SERVER['QUERY_STRING']))
    {
        $str_callback_url = $g_wx_epg_domain . '/' . $str_script_name;
    }
    else
    {
        $str_callback_url = $g_wx_epg_domain . '/' . $str_script_name . '?' . $_SERVER['QUERY_STRING'] . '&';
    }
    //将http_referer 记录到redirect_uri 中
    if (strpos($str_callback_url, '?') === false)
    {
        $str_callback_url .= '?web_replace_state_url='.urlencode($str_header_url).'&web_header_hash='.$str_haeder_hash;
    }
    else
    {
        $str_callback_url .= '&web_replace_state_url='.urlencode($str_header_url).'&web_header_hash='.$str_haeder_hash;
    }
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信获取CODE:微信回调地址：" . $str_callback_url,'message','info');
    $str_callback_url = urlencode($str_callback_url);
    //拼接向微信请求CODE的URL
    $state = '';
    $str_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$arr_account_info['nns_app_id']}&redirect_uri".
    "={$str_callback_url}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect&_rand_params=" . rand(0, 100000);
    em_return::set_ci_flow_desc($str_olg_file_path, "网页获取微信获取CODE:向微信请求CODE地址：" . $str_url,'message','info');

    header("Location:{$str_url}");
}