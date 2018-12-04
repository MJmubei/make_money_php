<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理创建控制器模板模块
 * @author pan.liang
 */
class c_controll_model extends CI_Controller
{
    /**
     * 创建controll模板列表
     */
    public function controll_list()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    /**
     * 创建controll模板
     */
    public function make_controll_model()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    /**
     * 删除web模板
     */
    public function del_controll_model()
    {
        $this->load_view_file(null,__LINE__);
    }
}
