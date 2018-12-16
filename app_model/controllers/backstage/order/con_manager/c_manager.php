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
        parent::__construct($str_class, $str_file, $str_method, $str_directory);
        $this->load->library('session');
    }

    public function index()
    {
        $this->_init_page();
        $this->load_view_file($this->auto_load_table('order','order_user', 'manager', 'query_tables'),__LINE__);
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
        $data['set']['user_id'] =  $user['data_info']['cms_id'];
        $data['set']['role_id'] =  $user['data_info']['cms_role_id'];
        $this->session->set_userdata($data['set']);
        $re = em_return::return_data(0,'登陆成功');
        $this->load_view_file($re,__LINE__);
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        unset($_SESSION['user']);
        $str_path_info = (strlen($this->get_str_load_stage()) >0) ? $this->get_str_load_stage() : '';
        $str_path_info .= (strlen($this->get_str_load_project()) >0) ? '/'.$this->get_str_load_project() : '';
        $str_path_info .= (strlen($this->get_str_load_model()) >0) ? '/'.$this->get_str_load_model() : '';
        $str_path_info .= (strlen($this->get_str_load_class()) >0) ? '/'.$this->get_str_load_class() : '';
        $str_path_info .= '/login';
        $this->load_view_file(array('1','2'),__LINE__);
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

        #todo 调取短信验证码，并验证短信

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


}