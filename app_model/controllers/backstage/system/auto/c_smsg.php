<?php
/**
 * Created by PhpStorm.
 * User: kan.yang@starcor.com
 * Date: 18-12-18
 * Time: 上午11:20
 */

include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/system/auto/c_smsg/system_smsg.class.php';
class c_smsg extends CI_Controller
{


    //sign key
    private $str_sign_key = '04997110aa2db7e27991ece0749064f4';

    /**
     * 默认构造函数
     */
    public function __construct()
    {
        $this->need_login = false;
        parent::__construct();
    }

    /**
     * 发送短信
     * @return array(
            'ret' => 0 成功
                     1 失败
                     2 验证码未过期，不再重复发送
            'code'   => '验证码'
            'reason' => '描述信息'
     * )
     */
    public function send_msg()
    {
        $this->flag_ajax_reurn = true;
        //参数验证
        $this->control_params_check(array(
            'cms_mobile_code' => array(
                'rule'   => 'mobile',
                'reason' => '手机号码非法'
            ),
            'cms_time' => array(
                'rule'   => 'notnull',
                'reason' => '约定时间非法'
            ),
            'sign' => array(
                'rule'   => 'notnull',
                'reason' => '签名非法'
            ),
        ),$this->arr_params);
        if($this->arr_params['sign'] != md5($this->arr_params['cms_mobile_code'] . $this->arr_params['cms_time'] . $this->str_sign_key))
        {
            $arr_send_ret = array('ret' => 1,'reason' => '失败：校验签名异常');
        }
        else
        {
            //发送验证码
            $obj_system_smsg = new system_smsg($this,'');
            $arr_send_ret = $obj_system_smsg->send_verify_code($this->arr_params['cms_mobile_code']);
        }

        $this->load_view_file($arr_send_ret,__LINE__);
    }

} 