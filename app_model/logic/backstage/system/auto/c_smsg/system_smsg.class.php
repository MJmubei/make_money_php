<?php
/**
 * Created by PhpStorm.
 * Use : 短信业务类
 * User: kan.yang@starcor.com
 * Date: 18-12-18
 * Time: 下午1:30
 */

include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Curl.class.php';
class system_smsg extends em_logic
{

    //短信接口地址
    private $API_SEND_URL = 'http://smssh1.253.com/msg/send/json';
    //账户
    private $API_ACCOUNT  = 'N4040642';
    //密码
    private $API_PASSWORD = 'ReqmwPgKY84a97';
    //错误码
    private $arr_error_status = array(
        '0'  =>'发送成功',
        '101'=>'无此用户',
        '102'=>'密码错',
        '103'=>'提交过快',
        '104'=>'系统忙',
        '105'=>'敏感短信',
        '106'=>'消息长度错',
        '107'=>'错误的手机号码',
        '108'=>'手机号码个数错',
        '109'=>'无发送额度',
        '110'=>'不在发送时间内',
        '112'=>'无此产品',
        '113'=>'扩展码格式错',
        '114'=>'可用参数组个数错误',
        '116'=>'签名不合法或未带签名',
        '117'=>'IP地址认证错,请求调用的IP地址不是系统登记的IP地址',
        '118'=>'用户没有相应的发送权限',
        '119'=>'用户已过期',
        '120'=>'违反防盗用策略',
        '123'=>'发送类型错误',
        '124'=>'白模板匹配错误',
        '125'=>'匹配驳回模板，提交失败',
        '128'=>'内容解码失败',
        '129'=>'JSON格式错误',
        '130'=>'请求参数错误',
        '133'=>'单一手机号错误',
    );
    //缓存验证码公共KEY
    private $str_verify_comm_key = 'system_smsg_verify_';
    //验证码缓存时间，默认5分钟
    private $int_cache_verify_expire_time = 300;

    /**
     * 发送短信
     * @param string $str_mobile    手机号码
     * @param string $str_msg       短信内容
     * @param string $str_send_time 定时发送短信时间，格式：yyyyMMddHHmm
     * @param bool $bool_report     是否需要状态报告
     * @param string $str_extend    下发短信号码扩展码
     * @param string $str_uuid      业务系统内的ID
     * @return array('ret' => 0/1,'reason' => '描述信息')
     */
    function send_msg($str_mobile,$str_msg,$str_send_time = '',$bool_report = false,$str_extend = '',$str_uuid = '')
    {
        $this->_init_app_config();

        //发送短信的接口参数
        $arr_post_data = array (
            'account'  => $this->API_ACCOUNT,
            'password' =>  $this->API_PASSWORD,
            'msg'      => $str_msg,
            'phone'    => $str_mobile,
            'sendtime' => $str_send_time,
            'report'   => $bool_report,
            'extend'   => $str_extend,
            'uid'      => $str_uuid,
        );

        //Header信息
        $arr_header_info = array('Content-Type:application/json');

        //初始化CURL处理类
        $obj_http_curl_class = new np_http_curl_class();
        $obj_response_data = $obj_http_curl_class->post($this->API_SEND_URL,json_encode($arr_post_data),$arr_header_info,30);

        //处理应答结果
        $obj_response_data = json_decode($obj_response_data,true);
        if($obj_response_data['code'] == 0)
        {
            return array('ret' => 0,'reason' => $this->arr_error_status[$obj_response_data['code']]);
        }
        else
        {
            return array('ret' => 1,'reason' => $this->arr_error_status[$obj_response_data['code']]);
        }
    }

    /**
     * 发送手机验证码
     * @param string $str_mobile 手机号码
     * @return array('ret' => 0/1/2,'reason' => '描述信息')
     */
    public function send_verify_code($str_mobile)
    {
        //存入Redis缓存
        $obj_redis = $this->_init_redis_object();
        $str_cache_key = $this->str_verify_comm_key . $str_mobile;
        //验证验证码是否已经过期
        $str_cache_code = $obj_redis->get($str_cache_key);
        if(is_string($str_cache_code) && !empty($str_cache_code))
        {//未过期，不再重新生成

            return array('ret' => 2,'验证码未过期，不再重新发送');
        }
        //重新发送验证码
        $str_code = $this->get_verify_code();
        $str_msg  = '验证码 ' . $str_code . ' ，请勿在任何短信或邮件链接的页面中输入验证码！';
        $arr_send_ret = $this->send_msg($str_mobile,$str_msg);
        if($arr_send_ret['ret'] == 0)
        {
            $obj_redis->save($str_cache_key,$str_code,$this->int_cache_verify_expire_time);
        }
        return $arr_send_ret;
    }

    /**
     * 验证码校验
     * @param string $str_mobile      手机号码
     * @param string $str_verify_code 验证码
     * @return array('ret' => 0/1/2,'reason' => '描述信息')
     */
    public function check_verify_code($str_mobile,$str_verify_code)
    {
        //获取Redis中的验证码
        $obj_redis = $this->_init_redis_object();
        $str_cache_code = $obj_redis->get($this->str_verify_comm_key . $str_mobile);
        //校验
        if(is_bool($str_cache_code) || empty($str_cache_code))
        {
            $arr_check_ret = array('ret' => 2,'reason' => '验证码已过期');
        }
        else
        {
            if($str_cache_code == $str_verify_code)
            {
                $arr_check_ret = array('ret' => 0,'reason' => '正确');
                $obj_redis->del($this->str_verify_comm_key . $str_mobile);
            }
            else
            {
                $arr_check_ret = array('ret' => 1,'reason' => '验证码校验失败');
            }
        }
        return $arr_check_ret;
    }

    /**
     * 生成验证码
     */
    public function get_verify_code()
    {
        $number_arr = range(0,9);
        shuffle($number_arr);
        $verify_code_mode[1] = array($number_arr[0],$number_arr[0],$number_arr[1],$number_arr[1],$number_arr[2],$number_arr[3]);
        $verify_code_mode[2] = array($number_arr[0],$number_arr[0],$number_arr[2],$number_arr[1],$number_arr[1],$number_arr[3]);
        $verify_code_mode[3] = array($number_arr[2],$number_arr[0],$number_arr[0],$number_arr[3],$number_arr[1],$number_arr[1]);
        $verify_code_mode[4] = array($number_arr[2],$number_arr[3],$number_arr[0],$number_arr[0],$number_arr[1],$number_arr[1]);
        $verify_code_mode[5] = array($number_arr[0],$number_arr[0],$number_arr[2],$number_arr[3],$number_arr[1],$number_arr[1]);
        $verify_code_mode[6] = array($number_arr[0],$number_arr[1],$number_arr[0],$number_arr[1],$number_arr[2],$number_arr[3]);
        $verify_code_mode[7] = array($number_arr[2],$number_arr[0],$number_arr[0],$number_arr[1],$number_arr[1],$number_arr[3]);
        $verify_code_mode[8] = array($number_arr[2],$number_arr[3],$number_arr[0],$number_arr[1],$number_arr[0],$number_arr[1]);

        $mode = mt_rand(1,8);
        $verify_code = $verify_code_mode[$mode];
        if(empty($verify_code[0]))
        {
            $number_arr_zero = range(1,9);
            shuffle($number_arr_zero);
            $verify_code[0] = $number_arr_zero[0];
        }
        return implode("", $verify_code);
    }

    /**
     * 初始化Redis处理类
     */
    private function _init_redis_object()
    {
        $this->obj_controller->load->driver('cache');
        return $obj_cache_redis = $this->obj_controller->cache->redis;
    }

    /**
     * 初始化短信系统配置
     */
    private function _init_app_config()
    {
        if(isset($this->obj_controller->config->config['short_message_config']))
        {
            $arr_smsg_config = $this->obj_controller->config->config['short_message_config'];
            if(!empty($arr_smsg_config['api_send_url']))
            {
                $this->API_SEND_URL = $arr_smsg_config['api_send_url'];
            }
            if(!empty($arr_smsg_config['api_account']))
            {
                $this->API_ACCOUNT  = $arr_smsg_config['api_account'];
            }
            if(!empty($arr_smsg_config['api_password']))
            {
                $this->API_PASSWORD = $arr_smsg_config['api_password'];
            }
        }
    }

}