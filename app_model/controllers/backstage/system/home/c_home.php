<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_home extends CI_Controller
{
    /**
     * 列表页
     */
    public function index()
    {
        $data = $this->system_auto_make_menu();
        if(is_array($data) && !empty($data))
        {
            $data = $this->system_auto_make_menu_arr($data);
        }
        $this->load_view_file(em_return::return_data(0,'ok',$data),__LINE__);
    }
}