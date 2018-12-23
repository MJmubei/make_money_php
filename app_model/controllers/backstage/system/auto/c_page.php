<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_page extends CI_Controller
{
    /**
     * 创建controll模板列表
     */
    public function index()
    {
        $this->_init_page();
        $result = $this->auto_load_table('system','auto','c_project','system_menu', 'query');
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_menu', 'query'),__LINE__);
    }
    
    
    public function auto_make_menu()
    {
        $base_dir = dirname(dirname(dirname(dirname(__FILE__))));
        $result = $this->auto_load_class('app_model/libraries/em_file.class.php');
        if($result['ret'] !=0)
        {
            return $result;
        }
        $em_file = new em_file($this,'php');
        $result_files = $em_file->get_files_list($base_dir);
        if(empty($result_files) ||!is_array($result_files))
        {
            return em_return::return_data(1,'NO file find');
        }
        $last_data = null;
        $result = $this->auto_load_table('system','auto','c_project','system_menu', 'edit',array('set'=>array('cms_state'=>1,'cms_modify_time'=>date("Y-m-d H:i:s"))));
        if($result['ret'] !=0)
        {
            return $result;
        }
        foreach ($result_files as $file_list)
        {
            $temp_path = trim(trim(trim(str_replace($this->config->_config_paths[0].'controllers', '', $file_list['path']),'\\'),'/'));
            $arr_temp = explode('/', $temp_path);
            if(!is_array($arr_temp) || empty($arr_temp) || count($arr_temp) != 4)
            {
                continue;
            }
            array_shift($arr_temp);
            $temp_project = array_shift($arr_temp);
            $temp_model = array_shift($arr_temp);
            $temp_child_model = array_shift($arr_temp);
            if(strlen($temp_child_model) <1 || strlen($temp_model) <1 ||strlen($temp_project) <1 || count(explode('.', $temp_child_model)) >2)
            {
                continue;
            }
            $result = $this->auto_load_table('system','auto','c_project','system_menu', 'add_edit',array('insert'=>array('cms_mark'=>$temp_project,'cms_state'=>0),'set'=>array('cms_state'=>0),'where'=>array('cms_mark'=>$temp_project)));
            if($result['ret'] !=0)
            {
                return $result;
            }
        }
        return em_return::return_data(0,'OK');
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
