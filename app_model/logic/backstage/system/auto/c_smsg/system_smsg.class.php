<?php
/**
 * Created by PhpStorm.
 * Use : 短信业务类
 * User: kan.yang@starcor.com
 * Date: 18-12-18
 * Time: 下午1:30
 */

include_once 'SignatureHelper.php';
include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . '/pub_class/libraries/Curl.class.php';
class system_smsg extends em_logic
{

    //是否启用https
    private $bool_security= false;
    //短信接口地址
    private $API_SEND_URL = 'dysmsapi.aliyuncs.com';
    //账户
    private $API_ACCOUNT  = 'LTAIzDNqjq2w6NdI';
    //密码
    private $API_PASSWORD = 'ZqFBhPCfFcHU7pRqB1bpSMSZ5p5w95';
    //短信签名
    private $API_SignName = '云裳供应链';
    //短信模板ID
    private $API_TemplateCode = 'SMS_152853072';

    //缓存验证码公共KEY
    private $str_verify_comm_key = 'system_smsg_verify_';
    //验证码缓存时间，默认5分钟
    private $int_cache_verify_expire_time = 300;

    /**
     * 发送短信
     * @param array  $arr_msg_params array(
            'PhoneNumbers'    => '手机号码',
            'SignName'        => '短信签名',
            'TemplateCode'    => '短信模板ID',
            'TemplateParam'   => '设置模板参数',
            'OutId'           => '发送短信流水号',  //选填
            'SmsUpExtendCode' => '上行短信扩展码',  //选填
     * )
     * @return array('ret' => 0/1,'reason' => '描述信息')
     */
    function send_msg($arr_msg_params)
    {
        $this->_init_app_config();

        //发送短信的接口参数
        $obj_send_helper = new SignatureHelper();
        //缺省值
        $arr_msg_params['SignName'] = $this->API_SignName;
        $arr_msg_params['TemplateCode'] = $this->API_TemplateCode;
        $obj_response_data = $obj_send_helper->request(
            $this->API_ACCOUNT,
            $this->API_PASSWORD,
            $this->API_SEND_URL,
            array_merge($arr_msg_params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $this->bool_security
        );
        //解析短信反馈
        if(strtoupper($obj_response_data['Code']) == 'OK')
        {
            return array('ret' => 0,'reason' => '成功');
        }
        else
        {
            return array('ret' => 1,'reason' => $obj_response_data['Message']);
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
        $arr_template_param = array('code' => $str_code);
        $arr_send_ret = $this->send_msg(array(
            'PhoneNumbers'    => $str_mobile,
            'TemplateParam'   => json_encode($arr_template_param),
        ));
        if($arr_send_ret['ret'] == 0)
        {
            $arr_send_ret['code'] = $str_code;
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
            if(!empty($arr_smsg_config['api_sign_name']))
            {
                $this->API_SignName = $arr_smsg_config['api_sign_name'];
            }
            if(!empty($arr_smsg_config['api_template_code']))
            {
                $this->API_TemplateCode = $arr_smsg_config['api_template_code'];
            }
        }
    }

}