<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理创建视图模板模块
 * @author pan.liang
 */
class c_web_model extends CI_Controller
{
    /**
     * 创建web模板列表
     */
    public function web_list()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    /**
     * 创建web模板
     */
    public function make_web_model()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    /**
     * 删除web模板
     */
    public function del_web_model()
    {
        $this->load_view_file(null,__LINE__);
    }
}
