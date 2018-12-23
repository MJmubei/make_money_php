<?php
/**
 * Created by PhpStorm.
 * User: fingal
 * Date: 2018/12/16
 * Time: 13:17
 */

class c_client_order extends CI_Controller
{
    public function __construct($str_class = null, $str_file = null, $str_method = null, $str_directory = null)
    {
        parent::__construct($str_class, $str_file, $str_method, $str_directory);
        $this->load->library('session');
    }

    /**
     * 点击新增订单
     * 第一步-选择订单类型
     */
    public function index()
    {
        $arr = array();
        $this->load_view_file($arr,__LINE__);
    }



}