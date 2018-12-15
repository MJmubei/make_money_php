<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 超级管理管理模块
 * @author pan.liang
 */
class c_menu extends CI_Controller
{
    /**
     * 列表页
     */
    public function index()
    {
        $system_file_list = array(
            array(
                'url'=>'system/auto/c_menu/add.php',
                'class'=>'system-auto-c_menu-add',
                'ajax'=>'system/auto/c_menu/add',
                'function'=>'add',
                'button_data'=>array(
                    array(
                        'name'=>'添加',
                        'icon'=>'fa-plus',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'system/auto/c_menu/edit.php',
                'class'=>'system-auto-c_menu-edit',
                'ajax'=>'system/auto/c_menu/edit',
                'function'=>'edit',
                'button_data'=>array(
                    array(
                        'name'=>'修改',
                        'icon'=>'fa-pencil-square-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'system/auto/c_menu/state.php',
                'class'=>'system-auto-c_menu-state',
                'ajax'=>'system/auto/c_menu/state',
                'function'=>'state',
                'button_data'=>array(
                    array(
                        'name'=>'启用',
                        'icon'=>'fa-unlock',
                        'params'=>'&cms_state=0',
                        'where'=>array(
                            'cms_state'=>0,
                        ),
                    ),
                    array(
                        'name'=>'禁用',
                        'icon'=>'fa-lock',
                        'params'=>'&cms_state=1',
                        'where'=>array(
                            'cms_state'=>1,
                        ),
                    ),
                ),
            ),
            array(
                'url'=>'system/auto/c_menu/delete.php',
                'class'=>'system-auto-c_menu-delete',
                'ajax'=>'system/auto/c_menu/delete',
                'function'=>'delete',
                'button_data'=>array(
                    array(
                        'name'=>'删除',
                        'icon'=>'fa-trash-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'system/auto/c_menu/auto_make_menu.php',
                'class'=>'system-auto-c_menu-auto_make_menu',
                'ajax'=>'system/auto/c_menu/auto_make_menu',
                'function'=>'auto',
                'button_data'=>array(
                    array(
                        'name'=>'自动生成菜单',
                        'icon'=>'fa-euro',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
        
        );
        $result_project = $this->auto_load_table('system','auto','c_project','system_project', 'query');
        if($result_project['ret'] !=0)
        {
            return $result_project;
        }
        $project_list = null;
        if(isset($result_project['data_info']) && is_array($result_project['data_info']) && !empty($result_project['data_info']))
        {
            foreach ($result_project['data_info'] as $val)
            {
                $project_list[$val['cms_id']] = $val;
            }
        }
        $this->_init_page();
        $where_params = array('where'=>($this->arr_params));
        $data_info = $this->auto_load_table('system','auto','c_project','system_menu', 'query',$where_params);
        $data_info['project_list'] = $project_list;
        $data_info['system_file_list'] = $system_file_list;
        $this->load_view_file($data_info,__LINE__);
    }
    

    
    /**
     * 添加
     */
    public function add()
    {
        $insert_params = array('insert'=>($this->arr_params));
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_menu', 'add',$insert_params),__LINE__);
    }
    
    
    /**
     * 修改
     */
    public function edit()
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
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_menu', 'edit',$edit_params),__LINE__);
    }
    
    
    
    /**
     * 删除
     */
    public function delete()
    {
        $cms_id = isset($this->arr_params['cms_id']) ? $this->arr_params['cms_id'] : null;
        if(empty($cms_id) && !is_array($cms_id))
        {
            $this->load_view_file(em_return::return_data(1,'删除参数条件为空'),__LINE__);
        }
        $delete_params = array(
            'where'=>array(
                'cms_id'=>$cms_id,
            ),
        );
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_menu', 'delete',$delete_params),__LINE__);
    }
    
    
    
    public function state()
    {
        $cms_id = isset($this->arr_params['cms_id']) ? $this->arr_params['cms_id'] : null;
        if(empty($cms_id) && !is_array($cms_id))
        {
            $this->load_view_file(em_return::return_data(1,'删除参数条件为空'),__LINE__);
        }
        $cms_state = isset($this->arr_params['cms_state']) ? $this->arr_params['cms_state'] : null;
        if(strlen($cms_state) <1)
        {
            $this->load_view_file(em_return::return_data(1,'删除参数条件为空'),__LINE__);
        }
        $edit_params = array(
            'set'=>array(
                'cms_state'=>$cms_state,
            ),
            'where'=>array(
                'cms_id'=>$cms_id,
            ),
        );
        $this->load_view_file($this->auto_load_table('system','auto','c_project','system_menu', 'edit',$edit_params),__LINE__);
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
        $result_poject = $this->auto_load_table('system','auto','c_project','system_menu', 'query',array('where'=>array('cms_mark'=>$temp_arr['prject'],'cms_state'=>0)));
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
