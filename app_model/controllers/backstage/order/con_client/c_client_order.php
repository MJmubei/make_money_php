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
    }



}