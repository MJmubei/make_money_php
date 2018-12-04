<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_menu extends CI_Controller
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
        $temp_arr = null;
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
            $temp_child_model = pathinfo($temp_child_model);
            $temp_child_model = isset($temp_child_model['filename']) ? $temp_child_model['filename'] : '';
            if(strlen($temp_child_model) <1 || strlen($temp_model) <1 ||strlen($temp_project) <1 || count(explode('.', $temp_child_model)) >2)
            {
                continue;
            }
            if(!isset($temp_arr['prject']) || (is_array($temp_arr['prject']) && !in_array($temp_project, $temp_arr['prject'])))
            {
                $temp_arr['prject'][] = $temp_project;
            }
            $temp_arr['list'][] = array(
                '1'=>array('key'=>$temp_project,'value'=>$temp_project),
                '2'=>array('key'=>$temp_project.'/'.$temp_model,'value'=>$temp_model),
                '3'=>array('key'=>$temp_project.'/'.$temp_model.'/'.$temp_child_model,'value'=>$temp_child_model),
            );
        }
        if(!is_array($temp_arr) || empty($temp_arr))
        {
            return em_return::return_data(1,'没有需要生成的目录');
        }
        $result_poject = $this->auto_load_table('system','auto','c_project','system_project', 'query',array('where'=>array('cms_mark'=>$temp_arr['prject'],'cms_state'=>0)));
        if($result_poject['ret'] !=0)
        {
            return $result_poject;
        }
        $result_poject = isset($result_poject['data_info']) ? $result_poject['data_info'] : null;
        if(empty($result_poject) || !is_array($result_poject))
        {
            return em_return::return_data(1,'查询无项目数据,请先检查项目数据是否生成');
        }
        $arr_poject = null;
        foreach ($result_poject as $value)
        {
            $arr_poject[$value['cms_mark']] = $value;
        }
        unset($result_poject);
        $data = null;
        foreach ($temp_arr['list'] as $value)
        {
            $cms_project_id = $arr_poject[$value[1]['value']]['cms_id'];
            $cms_project_name = $arr_poject[$value[1]['value']]['cms_name'];
            foreach ($value as $_key=>$_value)
            {
                if(isset($data[$_key][$_value['key']]))
                {
                    continue;
                }
                if($_key == 1)
                {
                    $cms_parent_id = 0;
                }
                else
                {
                    $temp_cms_parent_id = explode('/', $_value['key']);
                    array_pop($temp_cms_parent_id);
                    $temp_cms_parent_id = implode('/', $temp_cms_parent_id);
                    $cms_parent_id = $data[$_key-1][$temp_cms_parent_id];
                }
                $cms_name = ($_key == 1) ? $cms_project_name : $_value['value'];
                $cms_url = ($_key == 3) ? $_value['key'].'/index' : $_value['key'];
                $result = $this->auto_load_table('system', 'auto', 'c_project', 'system_menu', 'add_edit_one', array(
                    'insert' => array(
                        'cms_project_id' => $cms_project_id,
                        'cms_name'=>$cms_name,
                        'cms_mark'=> $_value['value'],
                        'cms_url' => $cms_url,
                        'cms_level' => $_key,
                        'cms_parent_id' => $cms_parent_id,
                        'cms_state'=>0,
                    ),
                    'set' => array(
                        'cms_url' => $cms_url,
                        'cms_state'=>0,
                    ),
                    'where' => array(
                        'cms_mark'=> $_value['value'],
                        'cms_project_id' => $cms_project_id,
                        'cms_parent_id' => $cms_parent_id,
                        'cms_level' => $_key,
                    )
                ));
                if($result['ret'] !=0)
                {
                    return $result;
                }
                $data[$_key][$_value['key']] = $result['data_info']['cms_id'];
            }
        }
        $result = $this->auto_load_table('system', 'auto', 'c_project', 'system_menu', 'delete', array('where' => array('cms_state' => 1)));
        return em_return::return_data(0,'OK');
    }
}
