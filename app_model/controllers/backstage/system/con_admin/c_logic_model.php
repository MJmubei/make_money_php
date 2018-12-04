<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理创建LOGIC模板模块
 * @author pan.liang
 */
class c_logic_model extends CI_Controller
{

    /**
     * 创建logic模板列表
     */
    public function logic_list()
    {
        $this->_init_page();
        $this->load_view_file($this->auto_load_table('system','system_tables', 'general', 'query_tables'),__LINE__);
    }
    
    /**
     * 创建logic模板
     */
    public function make_logic_model()
    {
        include_once APPPATH.'libraries/em_file.class.php';
        $arr_tables = array_filter(explode(',', (isset($this->arr_params['table_name']) && strlen($this->arr_params['table_name']) >0) ? $this->arr_params['table_name'] : ''));
        if(!is_array($arr_tables) || empty($arr_tables))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"行数:[".__LINE__."]传入参数为空:[".var_export($this->arr_params['table_name'],true)."]");
            $this->load_view_file(em_return::_return_error_data(),__LINE__);die;
        }
        foreach ($arr_tables as $table_val)
        {
            $table_val = (substr($table_val, 0,7)=='system_') ? $table_val : "system_".$table_val;
	        $result_data = $this->auto_load_table('system','system_tables', 'general', 'query_table_fileds',array('table_name'=>$table_val));
            if($result_data['ret'] !=0 || !is_array($result_data['data_info']) || empty($result_data['data_info']))
            {
                $this->load_view_file($result_data,__LINE__);
            }
            $result_data = $this->auto_make_model($this->arr_params['table_name'],'bulid_logic_file',$result_data['data_info']);
            if($result_data['ret'] !=0)
            {
                $this->load_view_file($result_data,__LINE__);
            }
            $table_val = substr($table_val, 3);
            $obj_em_file = new em_file($this);
            $result_data = $obj_em_file->make_file($result_data['data_info'],'data_model/model/logic',$table_val.".class.php");
            if($result_data['ret'] !=0)
            {
                $this->load_view_file($result_data,__LINE__);
            }
        }
        $this->load_view_file($result_data,__LINE__);
    }
    
    /**
     * 删除logic模板
     */
    public function del_logic_model()
    {
        $this->load_view_file(null,__LINE__);
    }
}
