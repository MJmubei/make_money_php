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

    /**
     * 发送短信
     * @return array(
            'ret' => 0 成功
                     1 失败
                     2 验证码未过期，不再重复发送
            'reason' => '描述信息'
     * )
     */
    public function send_msg()
    {
        $this->flag_ajax_reurn = true;
        if(empty($this->arr_params['cms_mobile_code']))
        {
            $arr_send_ret = array('ret' => 1,'reason' => '手机号码为必填参数');
        }
        else
        {
            $obj_system_smsg = new system_smsg($this,'');
            $arr_send_ret = $obj_system_smsg->send_verify_code($this->arr_params['cms_mobile_code']);
        }
        $this->load_view_file($arr_send_ret,__LINE__);
    }

} 