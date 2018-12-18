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

    public function index()
    {
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
        //用户角色
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

        $time = date('Y-m-d H:i:s');
        $add_params = array(
            'insert' => array(
                'telephone' => $this->arr_params['telephone'],
                'password' => $this->arr_params['password'],
                'create_time' => $time,
                'modify_time' => $time,
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'role_id' => $this->arr_params['role_id'],
            ),
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

        unset($params['where']['telephone']);
        //要修改手机号
        if (!empty($this->session->userdata['re_telephone']) && !isset($this->session->userdata['re_telephone']))
        {
            #todo 验证码验证手机号修改
            $params['set']['telephone'] =  $this->session->userdata['re_telephone'];
        }
        //角色
        if (!empty($this->session->userdata['role_id']) && !isset($this->session->userdata['role_id']))
        {
            $params['set']['rile_id'] =  $this->session->userdata['role_id'];
        }
        //email
        if (!empty($this->session->userdata['email']) && !isset($this->session->userdata['email']))
        {
            $params['set']['email'] =  $this->session->userdata['email'];
        }
        //描述
        if (!empty($this->session->userdata['desc']) && !isset($this->session->userdata['desc']))
        {
            $params['set']['desc'] =  $this->session->userdata['desc'];
        }
        //密码
        if (!empty($this->session->userdata['password']) && !isset($this->session->userdata['password']))
        {
            #todo 是否要验证原密码？
            $params['set']['password'] =  $this->session->userdata['password'];
        }

        $modify_info = $this->auto_load_table('order','manager', 'c_manager', 'manager', 'edit', $params);
        if ($modify_info['ret'] != 0)
        {
            $re = em_return::return_data(1,'登陆异常，请联系超级管理员');
            $this->load_view_file($re,__LINE__);
        }

        //密码
        if (!empty($this->session->userdata['password']) && !isset($this->session->userdata['password']))
        {
            $this->session->unset_userdata('telephone');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('role_id');
            echo "<script>window.location.href='login';</script>";
            exit;
        }


    }
}