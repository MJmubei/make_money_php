<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_project extends CI_Controller
{
    /**
     * 列表页
     */
    public function index()
    {
        $this->_init_page();
        $where_params = array('where'=>($this->arr_params));
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_project', 'query',$where_params),__LINE__);
    }
    
    /**
     * 列表页
     */
    public function tree()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    /**
     * 修改页面
     */
    public function add()
    {
        $this->load_view_file($this->arr_params,__LINE__);
    }
    
    public function do_add()
    {
        $insert_params = array('insert'=>($this->arr_params));
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_project', 'add',$insert_params),__LINE__);
    }
    
    /**
     * 修改页面
     */
    public function edit()
    {
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_project', 'query',array('where'=>$this->arr_params)),__LINE__);
    }
    
    
    public function do_edit()
    {
        $cms_id = isset($this->arr_params['cms_id']) ? $this->arr_params['cms_id'] : null;
        if(strlen($cms_id) <1)
        {
            $this->load_view_file(em_return::return_data(1,'修改参数条件为空'),__LINE__);
        }
        unset($this->arr_params['cms_id']);
        $edit_params = array(
            'where'=>array(
                'cms_id'=>$cms_id,
            ),
            'set'=>$this->arr_params,
        );
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_project', 'edit',$edit_params),__LINE__);
    }
    
    /**
     * delete页面
     */
    public function delete()
    {
        $this->load_view_file($this->arr_params,__LINE__);
    }
    
    /**
     * 自动生成项目
     */
    public function auto_make_project()
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
        $result = $this->auto_load_table('system','auto','c_project','system_project', 'edit',array('set'=>array('cms_state'=>1,'cms_modify_time'=>date("Y-m-d H:i:s"))));
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
            $result = $this->auto_load_table('system','auto','c_project','system_project', 'add_edit_one',array('insert'=>array('cms_mark'=>$temp_project,'cms_state'=>0,'cms_name'=>$temp_project),'set'=>array('cms_state'=>0,'cms_name'=>$temp_project),'where'=>array('cms_mark'=>$temp_project)));
            if($result['ret'] !=0)
            {
                return $result;
            }
        }
        $result = $this->auto_load_table('system', 'auto', 'c_project', 'system_project', 'delete', array('where' => array('cms_state' => 1)));
        return em_return::return_data(0,'OK');
    }
    
}
