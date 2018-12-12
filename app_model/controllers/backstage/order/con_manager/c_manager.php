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
        //验证用户是否存在
        $params = array(
            'where' => array(
                'telephone' => $this->arr_params['telephone'],
            ),
        );
        $user = $this->auto_load_table('order','order_manager', 'c_manager', 'manager', 'query_only', $params);
        if ($user != 0)
        {
            return em_return::return_data(1,'用户不存在', '', '', '', 'json');
        }
        var_dump($user);die;
        //用户密码加密后进行验证
        if ($user['password'] != md5(md5($this->arr_params['telephone']) . $this->arr_params['telephone']))
        {
            return em_return::return_data(1,'密码错误', '', '', '', 'json');
        }
        //添加到session
        $data = array(
            'set' => array(
                'login_time' => date('Y-m-d H:i:s'),
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'login_count' => $user['nns_login_count']+1,
            ),
            'where' => array(
                'id' => $user['nns_id'],
            ),
        );
        $modify_info = $this->auto_load_table('order','order_manager', 'c_manager', 'manager', 'edit', $data);
        if ($modify_info['ret'] != 0)
        {
            return em_return::return_data(1,'登陆异常，请联系超级管理员', '', '', '', 'json');
        }
        $this->session->set_userdata($data['set']);
        #todo 跳转到管理员个人中心页面
        $this->load_view_file(array('1','2'),__LINE__);
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

    public function registry()
    {
        //先查询是否已经存在了
        $user = $this->auto_load_table('order','order_manager', 'manager', 'query_only', $this->arr_params);

        if ($user != 0)
        {

        }

        $time = date('Y-m-d H:i:s');
        $this->arr_params['create_time'] = $time;
        $this->arr_params['modify_time'] = $time;
        $this->arr_params['id'] = $this->get_guid();
        $this->arr_params['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $add_user = $this->auto_load_table('order','order_manager', 'manager', 'add', $this->arr_params);

        $_SESSION['user'] = $user['data_info'];
    }


}