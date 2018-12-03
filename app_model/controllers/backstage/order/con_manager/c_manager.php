<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/11/29 10:58
 */
defined('BASEPATH') or exit('No direct script access allowed');
class c_manager extends CI_Controller
{


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
        $this->load_view_file(array('1','2'),__LINE__);
    }

    /**
     * 登陆动作
     */
    public function signin()
    {
        $user = $this->auto_load_table('order','order_manager', 'manager', 'query_only');
        if ($user != 0)
        {
            $this->load_view_file(array('1','2'),__LINE__);
        }
        $_SESSION['user'] = $user['data_info'];
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