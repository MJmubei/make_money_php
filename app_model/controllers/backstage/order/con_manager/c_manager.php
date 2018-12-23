<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/11/29 10:58
 */
defined('BASEPATH') or exit('No direct script access allowed');
class c_manager extends CI_Controller
{

    public function __construct($str_class = null, $str_file = null, $str_method = null, $str_directory = null)
    {
        $this->need_login = false;
        parent::__construct($str_class, $str_file, $str_method, $str_directory);
        $this->load->library('session');
    }

    public function test()
    {
        $this->load_view();
    }

    public function index()
    {
        $this->flag_ajax_reurn=true;
        if(empty($this->session->userdata('telephone')) || empty($this->session->userdata('role_id')))
        {
            echo "<script>window.location.href='../../../order/con_manager/c_manager/login';</script>";die;
        }

        $this->_init_page();

        if (empty($this->session->userdata['telephone']) || !isset($this->session->userdata['telephone']))
        {
            $re = em_return::return_data(1,'手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        if (empty($this->session->userdata['role_id']) || !isset($this->session->userdata['role_id']))
        {
            $re = em_return::return_data(1,'角色不能为空');
            $this->load_view_file($re,__LINE__);
        }
        if (empty($this->session->userdata['user_id']) || !isset($this->session->userdata['user_id']))
        {
            $re = em_return::return_data(1,'用户id不能为空');
            $this->load_view_file($re,__LINE__);
        }

        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->session->userdata['telephone'],
                'role_id' => $this->session->userdata['role_id'],
                'id' => $this->session->userdata['user_id'],
            ),
        );
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] != 0 || !is_array($user['data_info']) && count($user['data_info']) < 1)
        {
            $re = em_return::return_data(1,'用户不存在');
            $this->load_view_file($re,__LINE__);
        }
        switch ($user['data_info']['cms_role_id'])
        {
            case 1:
                $user['data_info']['cms_role_name'] = '订单管理员';
                break;
            case 3:
                $user['data_info']['cms_role_name'] = '生产商';
                break;
            case 4:
                $user['data_info']['cms_role_name'] = '供应商';
                break;
            case 5:
                $user['data_info']['cms_role_name'] = '样板师';
                break;
            case 6:
                $user['data_info']['cms_role_name'] = '样衣师';
                break;
        }
        $params = array(
            'user' => $user['data_info'],
        );
        $this->load_view_file($params,__LINE__);
    }

    /**
     * 登陆页面
     */
    public function login()
    {
        $this->load_view();
    }

    /**
     * 登陆动作
     */
    public function sigin()
    {
        if (empty($this->arr_params['telephone']) || !isset($this->arr_params['telephone']))
        {
            $re = em_return::return_data(1,'手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        if (empty($this->arr_params['password']) || !isset($this->arr_params['password']))
        {
            $re = em_return::return_data(1,'密码不能为空');
            $this->load_view_file($re,__LINE__);
        }

        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->arr_params['telephone'],
            ),
        );
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] != 0 || !is_array($user['data_info']) && count($user['data_info']) < 1)
        {
            $re = em_return::return_data(1,'用户不存在');
            $this->load_view_file($re,__LINE__);
        }
        //用户密码加密后进行验证
        if ($user['data_info']['cms_password'] != $this->arr_params['password'])
        {
            $re = em_return::return_data(1,'密码错误');
            $this->load_view_file($re,__LINE__);
        }
        //添加到session
        $data = array(
            'set' => array(
                'login_time' => date('Y-m-d H:i:s'),
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'login_count' => $user['data_info']['cms_login_count']+1,
            ),
            'where' => array(
                'id' => $user['data_info']['cms_id'],
            ),
        );
        $modify_info = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $data);
        if ($modify_info['ret'] != 0)
        {
            $re = em_return::return_data(1,'登陆异常，请联系超级管理员');
            $this->load_view_file($re,__LINE__);
        }
        $data['set']['telephone'] =  $this->arr_params['telephone'];
        $data['set']['user_id'] = isset($user['data_info']['cms_id']) ? $user['data_info']['cms_id'] : '';
        $data['set']['role_id'] =  isset($user['data_info']['cms_role_id']) ? $user['data_info']['cms_role_id'] : '';
        $this->session->set_userdata($data['set']);
        $re = em_return::return_data(0,'登陆成功');
        $this->load_view_file($re,__LINE__);
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        $this->session->unset_userdata('telephone');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role_id');
        echo "<script>window.location.href='login';</script>";
        exit;
    }

    /**
     * 注册页面
     */
    public function register()
    {
        $this->load_view_file(array('1','2'),__LINE__);

    }

    /**
     * 注册动作
     */
    public function registry()
    {
        //手机号
        if (empty($this->arr_params['telephone']) || !isset($this->arr_params['telephone']))
        {
            $re = em_return::return_data(1,'手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //密码
        if (empty($this->arr_params['password']) || !isset($this->arr_params['password']) || empty($this->arr_params['confirmPassword']) || !isset($this->arr_params['confirmPassword']))
        {
            $re = em_return::return_data(1,'密码不能为空');
            $this->load_view_file($re,__LINE__);
        }
        if ($this->arr_params['password'] != $this->arr_params['confirmPassword'])
        {
            $re = em_return::return_data(1,'两次密码不一致');
            $this->load_view_file($re,__LINE__);
        }
        //用户角色
        if (empty($this->arr_params['role_id']) || !isset($this->arr_params['role_id']))
        {
            $re = em_return::return_data(1,'请选择用户角色');
            $this->load_view_file($re,__LINE__);
        }
        //验证码
        if (empty($this->arr_params['num']) || !isset($this->arr_params['num']))
        {
            $re = em_return::return_data(1,'验证码不正确');
            $this->load_view_file($re,__LINE__);
        }


        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->arr_params['telephone'],
            ),
        );

        //先查询是否已经存在了
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] == 0 && is_array($user['data_info']) && count($user['data_info']) > 0)
        {
            $re = em_return::return_data(1,'用户已经存在,请直接登陆');
            $this->load_view_file($re,__LINE__);
        }

        //调取短信验证码，并验证短信
        include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/system/auto/c_smsg/system_smsg.class.php';
        $obj_system_smsg = new system_smsg($this,'');
        $arr_send_ret = $obj_system_smsg->check_verify_code($this->arr_params['telephone'], $this->arr_params['num']);
        if ($arr_send_ret['ret'] != 0)
        {
            $re = em_return::return_data(1,$arr_send_ret['reason']);
            $this->load_view_file($re,__LINE__);
        }
        $addr = isset($this->arr_params['city-picker3']) ? str_replace('/','', $this->arr_params['city-picker3']) : '';
        $time = date('Y-m-d H:i:s');
        $add_params = array(
            'insert' => array(
                'telephone' => $this->arr_params['telephone'],
                'password' => $this->arr_params['password'],
                'create_time' => $time,
                'modify_time' => $time,
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'role_id' => $this->arr_params['role_id'],
                'sex' => $this->arr_params['sex'],
                'username' => $this->arr_params['username'],
                'company_name' => $this->arr_params['company_name'],
                'country' => $this->arr_params['country'],
                'address' => $addr
            )
        );


        $add_user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'add', $add_params);
        if ($add_user['ret'] != 0)
        {
            $re = em_return::return_data(1,'注册失败');
            $this->load_view_file($re,__LINE__);
        }
        $this->load_view_file($add_user,__LINE__);
    }

    /**
     * 完善修改资料
     */
    public function edit_profile()
    {
        if(empty($this->session->userdata('telephone')) || empty($this->session->userdata('role_id')))
        {
            echo "<script>window.location.href='../../../order/con_manager/c_manager/login';</script>";die;
        }

        $this->_init_page();

        //手机号
        if (empty($this->session->userdata['telephone']) || !isset($this->session->userdata['telephone']))
        {
            $re = em_return::return_data(1,'手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }

        if (empty($this->session->userdata['user_id']) || !isset($this->session->userdata['user_id']))
        {
            $re = em_return::return_data(1,'用户id不能为空');
            $this->load_view_file($re,__LINE__);
        }

        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->session->userdata['telephone'],
                'id' => $this->session->userdata['user_id'],
            ),
        );
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] != 0 || !is_array($user['data_info']) && count($user['data_info']) < 1)
        {
            $re = em_return::return_data(1,'用户不存在');
            $this->load_view_file($re,__LINE__);
        }

        //用户名
        if (!empty($this->arr_params['username']) && isset($this->arr_params['username']))
        {
            $params['set']['name'] =  $this->arr_params['username'];
        }
        //email
        if (!empty($this->arr_params['email']) && isset($this->arr_params['email']))
        {
            $params['set']['email'] =  $this->arr_params['email'];
        }
        //国家
        if (!empty($this->arr_params['country']) && isset($this->arr_params['country']))
        {
            $params['set']['country'] =  $this->arr_params['country'];
        }
        //地址
        if (!empty($this->arr_params['address']) && isset($this->arr_params['address']))
        {
            $params['set']['address'] =  $this->arr_params['address'];
        }
        //成立时间
        if (!empty($this->arr_params['establish_date']) && isset($this->arr_params['establish_date']))
        {
            $params['set']['establish_date'] =  date('Y-m-d',strtotime($this->arr_params['establish_date']));
        }
        //主营产品
        if (!empty($this->arr_params['main_product']) && isset($this->arr_params['main_product']))
        {
            $params['set']['main_product'] =  $this->arr_params['main_product'];
        }
        //销售渠道
        if (!empty($this->arr_params['sale_channels']) && isset($this->arr_params['sale_channels']))
        {
            $params['set']['sale_channels'] =  $this->arr_params['sale_channels'];
        }
        //对公银行账户数据信息
        if (!empty($this->arr_params['bank_info']) && isset($this->arr_params['bank_info']))
        {
            $params['set']['bank_info'] =  $this->arr_params['bank_info'];
        }
        //递发货地址、电话、收件人
        if (!empty($this->arr_params['courier_info']) && isset($this->arr_params['courier_info']))
        {
            $params['set']['courier_info'] =  $this->arr_params['courier_info'];
        }
        //大件发货地址、电话、收件人
        if (!empty($this->arr_params['courier_big_info']) && isset($this->arr_params['courier_big_info']))
        {
            $params['set']['courier_big_info'] =  $this->arr_params['courier_big_info'];
        }
        //描述
        if (!empty($this->arr_params['desc']) && isset($this->arr_params['desc']))
        {
            $params['set']['desc'] =  $this->arr_params['desc'];
        }
        $params['set']['modify_time'] =  date('Y-m-d H:i:s');

        $modify_info = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $params);
        if ($modify_info['ret'] != 0)
        {
            $re = em_return::return_data(1,'修改失败');
            $this->load_view_file($re,__LINE__);
        }

        $this->load_view_file($modify_info,__LINE__);
    }

    /**
     * 通过手机短信找回密码，重置密码
     */
    public function re_password()
    {
        if (empty($this->arr_params) || !isset($this->arr_params) || is_null($this->arr_params))
        {
            $this->load_view_file(array('1','2'),__LINE__);
        }
        else
        {
            //手机号
            if (empty($this->arr_params['telephone']) || !isset($this->arr_params['telephone']))
            {
                $re = em_return::return_data(1,'手机号不能为空');
                $this->load_view_file($re,__LINE__);
            }
            //密码
            if (empty($this->arr_params['password']) || !isset($this->arr_params['password']) || empty($this->arr_params['confirmPassword']) || !isset($this->arr_params['confirmPassword']))
            {
                $re = em_return::return_data(1,'密码不能为空');
                $this->load_view_file($re,__LINE__);
            }
            if ($this->arr_params['password'] != $this->arr_params['confirmPassword'])
            {
                $re = em_return::return_data(1,'两次密码不一致');
                $this->load_view_file($re,__LINE__);
            }
            //验证码
            if (empty($this->arr_params['num']) || !isset($this->arr_params['num']))
            {
                $re = em_return::return_data(1,'验证码不正确');
                $this->load_view_file($re,__LINE__);
            }

            //验证用户是否存在
            $params = array(
                'where' => array(
                    'telephone' => $this->arr_params['telephone'],
                ),
            );

            //先查询是否已经存在了
            $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
            if ($user['ret'] != 0 || !is_array($user['data_info']) || count($user['data_info']) < 1)
            {
                $re = em_return::return_data(1,'用户不存在或找回密码异常');
                $this->load_view_file($re,__LINE__);
            }

            //调取短信验证码，并验证短信
            include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/system/auto/c_smsg/system_smsg.class.php';
            $obj_system_smsg = new system_smsg($this,'');
            $arr_send_ret = $obj_system_smsg->check_verify_code($this->arr_params['telephone'], $this->arr_params['num']);
            if ($arr_send_ret['ret'] != 0)
            {
                $re = em_return::return_data(1,$arr_send_ret['reason']);
                $this->load_view_file($re,__LINE__);
            }

            $edit_params = array(
                'set' => array(
                    'login_time' => date('Y-m-d H:i:s'),
                    'modify_time' => date('Y-m-d H:i:s'),
                    'pass_word_modify_time' => date('Y-m-d H:i:s'),
                    'password' => $this->arr_params['password']
                ),
                'where' => array(
                    'id' => $user['data_info']['cms_id'],
                    'telephone' => $user['data_info']['cms_telephone']
                ),
            );
            $add_user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $edit_params);
            if ($add_user['ret'] != 0)
            {
                $re = em_return::return_data(1,'重置密码失败');
                $this->load_view_file($re,__LINE__);
            }
            $this->load_view_file($add_user,__LINE__);
        }

    }

    /**
     * 后台修改密码
     */
    public function edit_password()
    {
        $this->flag_ajax_reurn = true;
        //手机号
        if (empty($this->arr_params['telephone']) || !isset($this->arr_params['telephone']))
        {
            $re = em_return::return_data(1,'手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //用户id
        if (empty($this->arr_params['user_id']) || !isset($this->arr_params['user_id']))
        {
            $re = em_return::return_data(1,'用户id不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //原密码
        if (empty($this->arr_params['old_password']) || !isset($this->arr_params['old_password']) ||
            empty($this->arr_params['new_password']) || !isset($this->arr_params['new_password'])
            || empty($this->arr_params['confirmPassword']) || !isset($this->arr_params['confirmPassword']))
        {
            $re = em_return::return_data(1,'密码不能为空');
            $this->load_view_file($re,__LINE__);
        }
        if ($this->arr_params['new_password'] != $this->arr_params['confirmPassword'])
        {
            $re = em_return::return_data(1,'两次新密码不一致');
            $this->load_view_file($re,__LINE__);
        }

        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->arr_params['telephone'],
                'id' => $this->arr_params['user_id'],
            ),
        );

        //先查询是否已经存在了
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] != 0 || !is_array($user['data_info']) || count($user['data_info']) < 1)
        {
            $re = em_return::return_data(1,'用户不存在或找回密码异常');
            $this->load_view_file($re,__LINE__);
        }
        //用户密码加密后进行验证
        if ($user['data_info']['cms_password'] != $this->arr_params['old_password'])
        {
            $re = em_return::return_data(1,'旧密码输入错误');
            $this->load_view_file($re,__LINE__);
        }

        $edit_params = array(
            'set' => array(
                'modify_time' => date('Y-m-d H:i:s'),
                'pass_word_modify_time' => date('Y-m-d H:i:s'),
                'password' => $this->arr_params['new_password']
            ),
            'where' => array(
                'id' => $user['data_info']['cms_id'],
                'telephone' => $user['data_info']['cms_telephone']
            ),
        );
        $add_user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $edit_params);
        if ($add_user['ret'] != 0)
        {
            $re = em_return::return_data(1,'重置密码失败');
            $this->load_view_file($re,__LINE__);
        }
        //修改后将session重置，然后进行重新登录
        //$this->session->unset_userdata('telephone');
        //$this->session->unset_userdata('user_id');
        //$this->session->unset_userdata('role_id');

        $this->load_view_file($add_user,__LINE__);
    }

    /**
     * 后台修改手机号
     */
    public function edit_telephone()
    {
        $this->flag_ajax_reurn = true;
        //手机号
        if (empty($this->arr_params['old_telephone']) || !isset($this->arr_params['old_telephone']))
        {
            $re = em_return::return_data(1,'旧手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //用户id
        if (empty($this->arr_params['user_id']) || !isset($this->arr_params['user_id']))
        {
            $re = em_return::return_data(1,'用户id不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //旧手机验证码
        if (empty($this->arr_params['num']) || !isset($this->arr_params['num']))
        {
            $re = em_return::return_data(1,'旧手机验证码不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //新手机号
        if (empty($this->arr_params['new_telephone']) || !isset($this->arr_params['new_telephone']))
        {
            $re = em_return::return_data(1,'新手机号不能为空');
            $this->load_view_file($re,__LINE__);
        }
        //新手机验证码
        if (empty($this->arr_params['re_num']) || !isset($this->arr_params['re_num']))
        {
            $re = em_return::return_data(1,'新手机验证码不能为空');
            $this->load_view_file($re,__LINE__);
        }


        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->arr_params['old_telephone'],
                'id' => $this->arr_params['user_id'],
            ),
        );

        //先查询是否已经存在了
        $user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user['ret'] != 0 || !is_array($user['data_info']) || count($user['data_info']) < 1)
        {
            $re = em_return::return_data(1,'用户不存在或找回密码异常');
            $this->load_view_file($re,__LINE__);
        }

        //调取短信验证码，并验证短信
        include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/system/auto/c_smsg/system_smsg.class.php';
        $obj_system_smsg = new system_smsg($this,'');
        $arr_send_ret = $obj_system_smsg->check_verify_code($this->arr_params['old_telephone'], $this->arr_params['num']);
        if ($arr_send_ret['ret'] != 0)
        {
            $re = em_return::return_data(1,'旧手机验证码' . $arr_send_ret['reason']);
            $this->load_view_file($re,__LINE__);
        }
        $arr_send_ret = $obj_system_smsg->check_verify_code($this->arr_params['new_telephone'], $this->arr_params['re_num']);
        if ($arr_send_ret['ret'] != 0)
        {
            $re = em_return::return_data(1,'新手机验证码' . $arr_send_ret['reason']);
            $this->load_view_file($re,__LINE__);
        }

        $edit_params = array(
            'set' => array(
                'modify_time' => date('Y-m-d H:i:s'),
                'telephone' => $this->arr_params['new_telephone'],
            ),
            'where' => array(
                'id' => $user['data_info']['cms_id'],
            ),
        );
        $add_user = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $edit_params);
        if ($add_user['ret'] != 0)
        {
            $re = em_return::return_data(1,'修改手机号失败');
            $this->load_view_file($re,__LINE__);
        }
        //修改后将session的手机号重置
        $this->session->set_userdata($this->arr_params['new_telephone']);

        $this->load_view_file($add_user,__LINE__);
    }


}