<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_admin extends CI_Controller
{
    /**
     * 创建controll模板列表
     */
    public function index()
    {
        $this->_init_page();
        $this->load_view_file($this->auto_load_table('system','system_tables', 'general', 'query_tables'),__LINE__);
    }
    
    /**
     * 创建controll模板列表
     */
    public function add()
    {
            $this->load_view_file(array('1','2'),__LINE__);
    }
    
    /**
     * 创建controll模板列表
     */
    public function click()
    {
        $this->load_view_file(array('1','2'),__LINE__);
    }

    /**
     * 创建controll模板列表
     */
    public function edit()
    {
        $this->load_view_file(array('1','2'),__LINE__);
    }
    
    /**
     * 创建controll模板列表
     */
    public function del()
    {
        $this->load_view_file(array('1','2'),__LINE__);
    }
    
    /**
     * 创建controll模板列表
     */
    public function rel_del()
    {
        $this->load_view_file(array('1','2'),__LINE__);
    }
    
    /**
     * 创建controll模板列表
     */
    public function change_pwd()
    {
        $this->load_view_file(array('1','2'),__LINE__);
    }
}
